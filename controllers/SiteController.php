<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use amnah\yii2\user\models\forms\LoginForm as AmnahLoginForm;
use amnah\yii2\user\models\User;
use app\models\SignupForm;
use app\models\Usersmain;

use app\models\ForgotPasswordForm;
use app\models\VerificationCodeForm;
use app\models\ResetPasswordForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $layout = 'login-signup/base';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => '@app/views/layouts/login-signup/parent',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['app/feed']);
        }

        $model = new AmnahLoginForm();


        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) {
                $user = User::findOne(['username' => $model->email]);
                if ($user && $user->validatePassword($model->password)) {
                    // Set active status to true
                    $userMain = Usersmain::findOne(['user_id' => $user->id]);
                    $userMain->active_status = true;
                    $userMain->save();

                    Yii::$app->user->login($user);
                    return $this->redirect(['app/feed']);
                } else {
                    Yii::$app->session->setFlash('error', 'Invalid username or password');
                }
            }
        }

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $userMain = Usersmain::findOne(['user_id' => Yii::$app->user->id]);
        if ($userMain) {
            $userMain->active_status = false;
            $userMain->save();
        }

        Yii::$app->user->logout();



        return $this->goHome();
    }





    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Signup successful! You can now log in.');

            return $this->redirect(['/site/login']);
        } else {
            Yii::$app->session->setFlash('error', 'Signup failed! Please try again.');
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();


        if (Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $verificationCode = sprintf("%05d", rand(0, 99999));

                    $email = $model->getAssociatedEmail();

                    Yii::$app->session->set('verification_code', $verificationCode);
                    Yii::$app->session->set('reset_email', $email);
                    // Get absolute path to logo
                    $logoPath = Yii::getAlias('@webroot/assets/images/logo.jpeg');

                    $message = Yii::$app->mailer->compose('passwordReset', [
                        'verificationCode' => $verificationCode,
                        'logoPath' => $logoPath
                    ]);

                    // Embed logo image
                    $message->embed($logoPath, ['fileName' => 'logo.jpeg']);

                    $message->setFrom(['kenjikun3289@gmail.com' => 'Nexus Admin'])
                        ->setTo($email)
                        ->setSubject('Password Reset Verification Code')
                        ->send();


                    return $this->renderAjax('_resetCode', [
                        'email' => $email,
                        'model' => new VerificationCodeForm(),
                        'verificationCode' => $verificationCode
                    ]);
                }
            }
        }

        return $this->render(
            'forgot-password',
            ['model' => $model]
        );
    }


    public function actionVerifyCode()
    {
        $model = new VerificationCodeForm();

        if (Yii::$app->request->isPjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $submittedCode = $model->getCode();
            $storedCode = Yii::$app->session->get('verification_code');

            if ($submittedCode === $storedCode) {
                // Code is correct, render success view
                return $this->renderAjax(
                    '_verificationSuccess',

                    [
                        'model' => new \app\models\ResetPasswordForm()
                    ]
                );
            } else {
                Yii::$app->session->setFlash('error', 'Invalid verification code.');
            }
        }

        return $this->renderAjax('_resetCode', [
            'model' => $model,
            'email' => Yii::$app->session->get('reset_email'),
        ]);
    }

    public function actionResetPassword()
    {
        $model = new ResetPasswordForm();

        if (Yii::$app->request->isPjax && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $email = Yii::$app->session->get('reset_email');

            if ($email === null) {
                Yii::$app->session->setFlash('error', 'Failed to reset password. Email not found.');
                return $this->redirect(['site/forgot-password']);
            }

            if ($model->updatePassword($email)) {
                Yii::$app->session->setFlash('success', 'Password has been reset successfully.');
                return $this->redirect(['site/login']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to reset password.');
            }
        }

        return $this->renderAjax('_verificationSuccess', [
            'model' => $model,
        ]);
    }

    public function actionGetPhotos()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $webPath = Yii::getAlias('@web/photos');

        // Manually specify the image files
        $imageFiles = [
            'image3.jpeg',
            'image2.jpeg',
            'image1.jpeg',
            'image4.jpeg',
            'image5.jpeg',
            'image6.jpeg',
            'image7.jpeg',
            'image8.jpeg',
            'image9.jpeg',
            'image10.jpeg',
            'image11.jpeg',
            'image12.jpeg',
            // Add more image filenames as needed
        ];

        $photos = [];
        foreach ($imageFiles as $file) {
            $photos[] = [
                'url' => $webPath . '/' . $file,
                'name' => $file
            ];
        }

        return [
            'error' => false,
            'photos' => $photos
        ];
    }
}
