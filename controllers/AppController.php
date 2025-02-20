<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Follows;
use app\models\Usersmain;
use app\models\Posts;
use app\models\Likes;
use amnah\yii2\user\models\User;
use yii\helpers\Html;
use yii\web\UploadedFile;
use app\models\Comments;
use app\models\CustomUser;
use yii\widgets\ActiveForm;
use app\models\Notifications;
use app\models\Messages;
use app\models\ChangePasswordForm;
use COM;
use CurlHandle;
use yii\web\Response;

class AppController extends Controller
{
    public $layout = 'navigations/parent';

    public function actionFeed()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $userId = Yii::$app->user->id;
        $followedUserIds = Follows::find()
            ->select('followed_id')
            ->where(['follower_id' => $userId])
            ->column();

        // Fetch followed users' posts
        $followedPosts = Posts::find()
            ->where(['user_id' => $followedUserIds])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // Fetch user's own posts
        $userPosts = Posts::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // Initialize post categories
        $notLikedPosts = [];
        $recentLikedPosts = [];
        $oldLikedPosts = [];
        $oneWeekAgo = strtotime('-1 week');

        // Categorize followed users' posts
        foreach ($followedPosts as $post) {
            $isLiked = Likes::find()
                ->where(['post_id' => $post->post_id, 'user_id' => $userId])
                ->exists();

            $postTime = strtotime($post->created_at);

            if (!$isLiked) {
                $notLikedPosts[] = $post;
            } else if ($postTime > $oneWeekAgo) {
                $recentLikedPosts[] = $post;
            } else {
                $oldLikedPosts[] = $post;
            }
        }

        // Sort each category by date
        usort($notLikedPosts, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));
        usort($recentLikedPosts, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));
        usort($oldLikedPosts, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));
        usort($userPosts, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));

        // Merge in priority order: not liked -> recent liked -> old liked -> user's posts
        $sortedPosts = array_merge($notLikedPosts, $recentLikedPosts, $oldLikedPosts, $userPosts);

        // Fetch users not followed by the current user
        $notFollowedUsers = Usersmain::find()
            ->where(['not in', 'user_id', $followedUserIds])
            ->andWhere(['<>', 'user_id', $userId])
            ->all();

        // Fetch active friends 
        $activeFriends = Usersmain::find()
            ->alias('u')
            ->innerJoin('follows f', 'f.followed_id = u.user_id')
            ->where(['f.follower_id' => $userId])
            ->andWhere(['u.active_status' => true])
            ->all();

        return $this->render('feed', [
            'posts' => $sortedPosts,
            'notFollowedUsers' => $notFollowedUsers,
            'activeFriends' => $activeFriends
        ]);
    }

    public function actionFriends()
    {


        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }


        $userId = Yii::$app->user->id;
        $searchModel = new Usersmain();
        $query = Follows::find()->where(['follower_id' => $userId]);

        $fr = null; // Initialize friend variable

        if (Yii::$app->request->get('id')) {
            $fr = Usersmain::findOne(Yii::$app->request->get('id'));
        }

        if ($searchModel->load(Yii::$app->request->post())) {
            $query->joinWith('followed')
                ->andFilterWhere(['like', 'usersmain.fullname', $searchModel->fullname]);
        }

        $follows = $query->all();

        return $this->render('friends', [
            'follows' => $follows,
            'searchModel' => $searchModel,

        ]);
    }

    public function actionProfile($id)
    {
        $friend = Usersmain::findOne($id);
        if (!$friend) {
            Yii::error("Friend not found: ID $id");
            throw new \yii\web\NotFoundHttpException("Friend not found.");
        }

        $posts = Posts::find()->where(['user_id' => $id])->all();

        Yii::info("Loaded profile for friend ID $id with " . count($posts) . " posts.");
        $currentUserId = Yii::$app->user->id;
        $isFollowing = Follows::find()
            ->where(['follower_id' => $currentUserId, 'followed_id' => $id])
            ->exists();

        return $this->renderAjax('_profile', [
            'friend' => $friend,
            'posts' => $posts,
            'postsCount' => $friend->getPosts()->count(),
            'followersCount' => $friend->getFollows0()->count(),
            'followingsCount' => $friend->getFollows()->count(),
            'isFollowing' => $isFollowing,
            'isUser' => $friend->user_id === $currentUserId

        ]);
    }

    public function actionProfileView($username)
    {
        $userId = Usersmain::findOne(['username' => $username]);

        if ($userId === null) {
            throw new \yii\web\NotFoundHttpException('The requested user does not exist.');
        }

        $friend = Usersmain::findOne($userId);
        $posts = Posts::find()->where(['user_id' => $userId])->all();
        $currentUserId = Yii::$app->user->id;


        $isFollowing = Follows::find()
            ->where(['follower_id' => $currentUserId, 'followed_id' => $userId])
            ->exists();

        $isUser = false;

        if ($userId->user_id === $currentUserId) {
            $isUser = true;

            $friend =  $userId;
        }

        return $this->render('userprofile', [
            'id' => $userId,
            'friend' => $friend,
            'posts' => $posts,
            'postsCount' => $friend->getPosts()->count(),
            'followersCount' => $friend->getFollows0()->count(),
            'followingsCount' => $friend->getFollows()->count(),
            'isFollowing' => $isFollowing,
            'isUser' => $isUser
        ]);
    }

    public function actionLike()
    {
        $postId = Yii::$app->request->post('postId');
        $userId = Yii::$app->user->id;

        $like = new Likes();
        $like->post_id = $postId;
        $like->user_id = $userId;

        if ($like->save()) {

            $post = Posts::findOne($postId);
            $notification = new Notifications();
            $notification->sender_id = $userId;
            $notification->receiver_id = $post->user_id;
            $notification->notification_text = ' liked your post.';
            $notification->post_id = $postId;
            $notification->type = 'like';
            $notification->created_at = date('Y-m-d H:i:s');
            $notification->is_read = 0;
            $notification->save();
            return $this->renderPartial('_likeButton', [
                'post' => $post,
            ]);
        }
        return false;
    }

    public function actionUnlike()
    {

        $postId = Yii::$app->request->post('postId');
        $userId = Yii::$app->user->id;

        $like = Likes::find()->where(['post_id' => $postId, 'user_id' => $userId])->one();

        if ($like && $like->delete()) {
            Notifications::deleteAll([
                'sender_id' => $userId,
                'post_id' => $postId,
                'type' => 'like'
            ]);

            $post = Posts::findOne($postId);

            return $this->renderPartial('_likeButton', [
                'post' => $post,
            ]);
        }
        return false;
    }


    public function actionFollow()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->request->post('id');
        $currentUserId = Yii::$app->user->id;

        $follow = new Follows();
        $follow->follower_id = $currentUserId;
        $follow->followed_id = $userId;


        if ($follow->save()) {

            return [
                'success' => true,
                'button' => $this->renderAjax('_followButton', [
                    'friend' => Usersmain::findOne($userId),
                    'isFollowing' => true
                ])
            ];
        }
    }

    public function actionUnfollow()
    {
        $userId = Yii::$app->request->post('id');
        $currentUserId = Yii::$app->user->id;

        $follow = Follows::findOne(['follower_id' => $currentUserId, 'followed_id' => $userId]);

        if ($follow && $follow->delete()) {
            Yii::$app->session->setFlash('success', 'You have unfollowed this user.');
        } else {
            Yii::$app->session->setFlash('error', 'Unable to unfollow this user.');
        }

        /*
        if (Yii::$app->request->isPjax) {
            return $this->renderPartial('_followButton', [
                'friend' => Usersmain::findOne($userId),
                'isFollowing' => false,
            ]);
        }
    */

        return $this->redirect('friends');
    }

    public function actionComment()
    {

        if (Yii::$app->request->isPjax) {
            $postId = Yii::$app->request->post('postId');
            $content = Yii::$app->request->post('content');

            $comment = new Comments();
            $comment->post_id = $postId;
            $comment->user_id = Yii::$app->user->id;
            $comment->content = $content;
            $comment->created_at = date('Y-m-d H:i:s');

            if ($comment->save()) {
                $post = Posts::findOne($postId);
                $notification = new Notifications();
                $notification->sender_id = Yii::$app->user->id;
                $notification->receiver_id = $post->user_id;
                $notification->notification_text = ' commented: ';
                $notification->post_id = $postId;
                $notification->type = 'comment';
                $notification->comment_id = $comment->comment_id;

                $notification->created_at = date('Y-m-d H:i:s');
                $notification->is_read = 0;
                $notification->save();
                return $this->renderPartial('_comments', [
                    'post' => $post
                ]);
            }
        }
    }

    public function actionNotifications()
    {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }



        $userId = Yii::$app->user->id;
        $followedUserIds = Follows::find()
            ->select('followed_id')
            ->where(['follower_id' => $userId])
            ->column();

        $notifications = Notifications::find()
            ->where(['sender_id' => $followedUserIds])
            ->andWhere(['type' => ['post', 'like', 'comment']])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('notifications', [
            'notifications' => $notifications,
        ]);
    }

    public function actionCheckNewNotifications($lastNotificationId = 0)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $userId = Yii::$app->user->id;
        $followedUserIds = Follows::find()
            ->select('followed_id')
            ->where(['follower_id' => $userId])
            ->column();

        $newNotifications = Notifications::find()
            ->with(['sender', 'post'])
            ->where(['>', 'notification_id', $lastNotificationId])
            ->andWhere([
                'or',
                ['receiver_id' => $userId], // Notifications specifically for current user
                [
                    'and',
                    ['type' => 'post'],
                    ['sender_id' => $followedUserIds]
                ]
            ])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        if (!empty($newNotifications)) {
            $html = '';
            foreach ($newNotifications as $notification) {
                $html .= $this->renderPartial('_notification_item', ['notification' => $notification]);
            }
            return [
                'success' => true,
                'html' => $html,
                'lastNotificationId' => max(array_column($newNotifications, 'notification_id'))
            ];
        }

        return ['success' => false];
    }

    public function actionSearch()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }


        $userId = Yii::$app->user->id;
        $searchModel = new Usersmain();
        $users = [];

        if ($searchModel->load(Yii::$app->request->post())) {
            $users = Usersmain::find()
                ->where(['like', 'fullname', $searchModel->fullname])
                ->andWhere(['<>', 'user_id', $userId])
                ->all();
        }

        return $this->render('search', [
            'searchModel' => $searchModel,
            'users' => $users,
        ]);
    }

    public function actionFollowSuggestion()
    {
        if (Yii::$app->request->isPjax) {
            $userId = Yii::$app->request->post('id');
            $currentUserId = Yii::$app->user->id;
            $follow = new Follows();
            $follow->follower_id = $currentUserId;
            $follow->followed_id = $userId;


            $notification = new Notifications();
            $notification->sender_id = $currentUserId;
            $notification->receiver_id = $userId;
            $notification->type = 'follow';
            $notification->notification_text = 'Started Following You';
            $notification->created_at = date('Y-m-d H:i:s');
            $notification->is_read = 0;
            $notification->post_id = 0;
            $notification->save();

            if (!$notification->save()) {
                Yii::error('Notification save failed: ' . json_encode($notification->errors));
            }

            if ($follow->save()) {


                return $this->renderPartial('_suggestionFollowButton', [
                    'user' => Usersmain::findOne($userId),
                    'isFollowing' => true
                ]);
            }
        }
        return false;
    }


    public function actionCreatePost()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isPjax) {
            $post = new Posts();
            $post->user_id = Yii::$app->user->id;
            $post->content = Yii::$app->request->post('caption');
            $post->created_at = date('Y-m-d H:i:s');

            $imageFile = UploadedFile::getInstanceByName('image');
            if ($imageFile) {
                $uploadPath = Yii::getAlias('@webroot/uploads/posts/');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $imageName = 'post_' . time() . '.' . $imageFile->extension;
                $imagePath = '/uploads/posts/' . $imageName;
                $fullPath = Yii::getAlias('@webroot/') . $imagePath;

                if ($imageFile->saveAs($fullPath)) {
                    $post->image_path = $imagePath;
                } else {
                    throw new \Exception('Failed to save image');
                }
            }

            if ($post->save()) {
                // Create a notification entry
                $notification = new Notifications();
                $notification->sender_id = Yii::$app->user->id;
                $notification->type = 'post';
                $notification->notification_text = ' added a new post.';
                $notification->created_at = date('Y-m-d H:i:s');
                $notification->is_read = 0;
                $notification->post_id = $post->post_id;
                if (!$notification->save()) {
                    throw new \Exception('Failed to save notification: ' . json_encode($notification->errors));
                }

                $this->redirect(['app/feed']);
            } else {
                throw new \Exception('Failed to save post');
            }
        }

        return [
            'success' => false,
            'message' => 'Invalid request',
        ];
    }

    public function actionMessages()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $currentUserId = Yii::$app->user->id;

        $users = Usersmain::find()
            ->alias('u')
            ->select(['u.*', 'MAX(m.created_at) as last_message_time'])
            ->leftJoin(
                'messages m',
                '(m.sender_id = u.user_id AND m.receiver_id = :currentUserId) 
            OR (m.receiver_id = u.user_id AND m.sender_id = :currentUserId)',
                [':currentUserId' => $currentUserId]
            )
            ->where([
                'in',
                'u.user_id',
                Follows::find()
                    ->select('followed_id')
                    ->where(['follower_id' => $currentUserId])
            ])
            ->groupBy('u.user_id')
            ->orderBy(['last_message_time' => SORT_DESC])
            ->all();

        return $this->render('messages', [
            'users' => $users
        ]);
    }

    public function actionLoadChat($userId)
    {
        $selectedUser = Usersmain::findOne($userId);
        $currentUserId = Yii::$app->user->id;

        $messages = Messages::find()
            ->where([
                'or',
                ['sender_id' => $currentUserId, 'receiver_id' => $userId],
                ['sender_id' => $userId, 'receiver_id' => $currentUserId]
            ])
            ->orderBy(['created_at' => SORT_ASC])
            ->all();


        $key = Yii::$app->params['messageEncryptionKey'];
        foreach ($messages as $message) {
            $combined = base64_decode($message->content);
            $iv = substr($combined, 0, 16);
            $encrypted = substr($combined, 16);
            $message->content = openssl_decrypt(
                $encrypted,
                'AES-256-CBC',
                $key,
                0,
                $iv
            );
        }
        $newMessage = new Messages();

        return $this->renderAjax('_chatWindow', [
            'selectedUser' => $selectedUser,
            'messages' => $messages,
            'newMessage' => $newMessage,
        ]);
    }

    public function actionSendMessage()
    {
        if (Yii::$app->request->isAjax) {
            $newMessage = new Messages();
            if ($newMessage->load(Yii::$app->request->post())) {
                // Encrypt message content
                $key = Yii::$app->params['messageEncryptionKey'];
                $iv = openssl_random_pseudo_bytes(16);
                $encrypted = openssl_encrypt(
                    $newMessage->content,
                    'AES-256-CBC',
                    $key,
                    0,
                    $iv
                );

                $newMessage->content = base64_encode($iv . $encrypted);
                $newMessage->sender_id = Yii::$app->user->id;
                $newMessage->receiver_id = Yii::$app->request->post('userId');
                $newMessage->created_at = date('Y-m-d H:i:s');

                if ($newMessage->save()) {
                    $messages = Messages::find()
                        ->where([
                            'or',
                            ['sender_id' => Yii::$app->user->id, 'receiver_id' => $newMessage->receiver_id],
                            ['sender_id' => $newMessage->receiver_id, 'receiver_id' => Yii::$app->user->id]
                        ])
                        ->orderBy(['created_at' => SORT_ASC])
                        ->all();


                    foreach ($messages as $message) {
                        $combined = base64_decode($message->content);
                        $iv = substr($combined, 0, 16);
                        $encrypted = substr($combined, 16);
                        $message->content = openssl_decrypt(
                            $encrypted,
                            'AES-256-CBC',
                            $key,
                            0,
                            $iv
                        );
                    }

                    return $this->renderAjax('_message', [
                        'messages' => $messages,
                        'selectedUser' => Usersmain::findOne($newMessage->receiver_id)
                    ]);
                }
            }
        }
    }

    public function actionCheckNewMessages($userId, $lastMessageTime, $processedIds = [])
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $currentUserId = Yii::$app->user->id;

        $query = Messages::find()
            ->where([
                'and',
                [
                    'sender_id' => $userId,
                    'receiver_id' => $currentUserId
                ],
                ['>', 'created_at', $lastMessageTime]
            ]);

        if (!empty($processedIds)) {
            $query->andWhere(['not in', 'message_id', $processedIds]);
        }

        $newMessages = $query->orderBy(['created_at' => SORT_ASC])
            ->all();

        if (!empty($newMessages)) {
            $key = Yii::$app->params['messageEncryptionKey'];

            foreach ($newMessages as $message) {
                $combined = base64_decode($message->content);
                $iv = substr($combined, 0, 16);
                $encrypted = substr($combined, 16);
                $message->content = openssl_decrypt(
                    $encrypted,
                    'AES-256-CBC',
                    $key,
                    0,
                    $iv
                );
            }

            $messageIds = array_map(function ($message) {
                return $message->message_id;
            }, $newMessages);

            return [
                'success' => true,
                'html' => $this->renderPartial('_message', [
                    'messages' => $newMessages,
                    'selectedUser' => Usersmain::findOne($userId)
                ]),
                'lastMessageTime' => end($newMessages)->created_at,
                'messageIds' => $messageIds
            ];
        }

        return ['success' => false];
    }

    public function actionCheckNotifications($lastCheckTime)
    {
        if (!Yii::$app->request->isAjax) {
            return;
        }

        $newMessages = Messages::find()
            ->alias('m')
            ->select(['m.*', 'u.fullname as sender'])
            ->leftJoin('usersmain u', 'u.user_id = m.sender_id')
            ->where(['m.receiver_id' => Yii::$app->user->id])
            ->andWhere(['>', 'm.created_at', $lastCheckTime])
            ->orderBy(['m.created_at' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->asJson([
            'success' => true,
            'newMessages' => array_map(function ($message) {
                return [
                    'id' => $message['message_id'],
                    'sender' => $message['sender'],
                    'time' => $message['created_at']
                ];
            }, $newMessages),
            'currentTime' => date('Y-m-d H:i:s')
        ]);
    }

    public function actionSettings()
    {


        return $this->redirect(['app/settings']);
    }

    public function actionAdmin()
    {
        if (!Usersmain::findOne(Yii::$app->user->id)->admin_status) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        $searchTerm = Yii::$app->request->get('search');
        $query = (new \yii\db\Query())
            ->select([
                'usersmain.*',
                'COUNT(posts.post_id) as post_count'
            ])
            ->from('usersmain')
            ->leftJoin('posts', 'usersmain.user_id = posts.user_id');

        if ($searchTerm) {
            $query->andWhere([
                'or',
                ['like', 'fullname', $searchTerm],
                ['like', 'username', $searchTerm],
                ['like', 'email', $searchTerm]
            ]);
        }

        $users = $query->groupBy('usersmain.user_id')->all();

        if (Yii::$app->request->isPjax) {
            return $this->renderPartial('_userTable', [
                'users' => $users
            ]);
        }

        return $this->render('admin', [
            'users' => $users,
            'totalUsers' => Usersmain::find()->count(),
            'activeUsers' => Usersmain::find()->where(['active_status' => true])->count(),
            'totalPosts' => Posts::find()->count(),
        ]);
    }

    public function actionDeleteUser($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            Posts::deleteAll(['user_id' => $id]);
            Likes::deleteAll(['user_id' => $id]);
            Comments::deleteAll(['user_id' => $id]);
            Notifications::deleteAll(['sender_id' => $id]);
            Notifications::deleteAll(['receiver_id' => $id]);
            Follows::deleteAll(['follower_id' => $id]);
            Follows::deleteAll(['followed_id' => $id]);
            $user = User::findOne($id);
            if ($user) {
                $user->delete();
            }
            Usersmain::deleteAll(['user_id' => $id]);

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'User deleted successfully');
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error deleting user');
        }

        return $this->redirect(['admin']);
    }

    public function actionDeleteModal($id)
    {
        $user = Usersmain::findOne($id);

        if ($user->admin_status) {
            return $this->renderAjax('_deleteModal', [
                'id' => $id,
                'isAdmin' => true
            ]);
        }

        return $this->renderAjax('_deleteModal', [
            'id' => $id,
            'isAdmin' => false
        ]);
    }

    public function actionUpdateProfilePicture()
    {
        $image = UploadedFile::getInstanceByName('profilePicture');
        if ($image && $image->size > 0) {
            $user = CustomUser::findOne(Yii::$app->user->id);
            $usersMain = Usersmain::findOne(Yii::$app->user->id);

            if ($user && $usersMain) {

                $uploadDir = Yii::getAlias('@webroot/uploads/profile_pictures');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = 'profile_' . Yii::$app->user->id . '_' . time() . '.' . $image->extension;
                $filePath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;
                $webPath = '/uploads/profile_pictures/' . $fileName;

                if ($image->saveAs($filePath)) {
                    $user->profile_picture = $webPath;
                    $usersMain->profile_image_path = $webPath;

                    if ($user->save() && $usersMain->save()) {
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        }

        Yii::$app->session->setFlash('error', 'Failed to update profile picture');
        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionUpdateProfile()
    {
        if (Yii::$app->request->isPost) {
            $usersMain = Usersmain::findOne(Yii::$app->user->id);
            $user = CustomUser::findOne(Yii::$app->user->id);


            if ($usersMain) {
                $usersMain->fullname = Yii::$app->request->post('fullname');
                $usersMain->bio = Yii::$app->request->post('bio');
                $user->fullname = Yii::$app->request->post('fullname');

                if ($usersMain->save()) {
                    Yii::$app->session->setFlash('success', 'Profile updated successfully');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update profile');
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = CustomUser::findOne(Yii::$app->user->id);
            $user->password = \Yii::$app->security->generatePasswordHash($model->newPassword);

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionValidatePassword()
    {
        $model = new ChangePasswordForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    public function actionSearchMessages($query)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_HTML;

        try {
            if (Yii::$app->request->isAjax) {
                $users = Usersmain::find()
                    ->where(['like', 'fullname', $query])
                    ->andWhere(['!=', 'user_id', Yii::$app->user->id])
                    ->all();

                // Debug output
                Yii::debug('Search query: ' . $query);
                Yii::debug('Found users: ' . count($users));

                return $this->renderPartial('_message_search_results', [
                    'users' => $users
                ]);
            }
        } catch (\Exception $e) {
            Yii::error('Search error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function actionDora()
    {

        return $this->render('dora');
    }

    public function actionUploadImage()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax) {
            $uploadedFile = UploadedFile::getInstanceByName('imageFile');

            if ($uploadedFile) {
                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = Yii::getAlias('@webroot/message/photos/') . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $message = new Messages();
                    $message->sender_id = Yii::$app->user->id;
                    $message->receiver_id = Yii::$app->request->post('userId');
                    $message->content = $fileName;
                    $message->message_type = 'image';
                    $message->created_at = date('Y-m-d H:i:s');

                    if ($message->save()) {
                        return [
                            'success' => true,
                            'html' => $this->renderPartial('_message', [
                                'messages' => [$message],
                                'selectedUser' => Usersmain::findOne($message->receiver_id)
                            ])
                        ];
                    }
                }
            }
        }

        return ['success' => false];
    }

    public function actionSearchUsers($query)
    {
        if (empty($query)) {
            return $this->renderPartial('_usersList', ['users' => []]);
        }

        $users = Usersmain::find()
            ->where(['like', 'fullname', $query])
            ->orWhere(['like', 'username', $query])
            ->andWhere(['!=', 'user_id', Yii::$app->user->id])
            ->limit(20)
            ->all();

        return $this->renderPartial('_usersList', [
            'users' => $users
        ]);
    }

    public function actionGetLikes($postId)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'success' => false,
                'error' => 'Authentication required'
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        try {
            $post = Posts::findOne($postId);
            if (!$post) {
                return [
                    'success' => false,
                    'error' => 'Post not found'
                ];
            }

            $likes = Likes::find()
                ->where(['post_id' => $postId])
                ->with('user')
                ->all();

            $likeData = array_map(function ($like) {
                return [
                    'fullname' => $like->user->fullname,
                    'username' => $like->user->username,
                ];
            }, $likes);

            return [
                'success' => true,
                'likes' => $likeData
            ];
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), 'error');
            return [
                'success' => false,
                'error' => 'Failed to load likes: ' . $e->getMessage()
            ];
        }
    }
}
