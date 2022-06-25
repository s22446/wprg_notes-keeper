<div class="notes-columns-container">
    <div class="notes-columns">
        <?php foreach ($userColumns as $userColumn) : ?>
            <div class="notes-column" data-column-id="<?= $userColumn['id'] ?>">
                <div class="notes-column-header">
                    <div class="column-header-content">
                        <div class="remove-column" onclick="removeColumn(this)"><span class="remove-button-tooltip">Remove column</span></div>
                        <div class="column-name"><?= $userColumn['name'] ?></div>
                    </div>
                </div>
                <div class="notes-column-content"></div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="logout-link"><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">LOGOUT</a></div>
</div>
<div class="templates">
    <div id="column-template">
        <div class="notes-column">
            <div class="notes-column-header">
                <div class="column-header-content">
                    <div class="add-column"><span class="add-button-tooltip">Add column</span></div>
                    <div class="column-name"><input type="text" class="class-name-input" placeholder="Add column"></div>
                </div>
            </div>
            <div class="notes-column-content"></div>
        </div>
    </div>
    <div id="column-delete-template">
        <div class="remove-column" onclick="removeColumn(this)"><span class="remove-button-tooltip">Remove column</span></div>
    </div>
</div>
