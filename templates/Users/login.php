<?= $this->Flash->render() ?>
<div class="login-form-container">
    <div class="login-header">
        <div class="login-header-text">NOTES KEEPER</div>
    </div>
    <div class="login-main">
        <?= $this->Form->create(null, ['url' => '/users/login']) ?>
            <div class="login-main-text">LOGIN</div>
            <div class="login-input-container">
                <div class="login-input-text">Email:</div>
                <div class="login-input">
                    <?= $this->Form->text('email', ['class' => 'login-input-box', 'type' => 'email', 'required' => true]) ?>
                </div>
            </div>
            <div class="login-input-container">
                <div class="login-input-text">Password:</div>
                <div class="login-input">
                    <?= $this->Form->password('password', ['class' => 'login-input-box', 'required' => true]) ?>
                </div>
            </div>
            <div class="login-create-account"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'create']) ?>">CREATE ACCOUNT</a></div>
            <div class="login-button-containter"><?= $this->Form->submit(__('Login'), ['class' => 'login-button']) ?></div>
        <?= $this->Form->end() ?>
    </div>
</div>
