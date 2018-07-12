<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityLog $activityLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $activityLog->idLog],
                ['confirm' => __('Are you sure you want to delete # {0}?', $activityLog->idLog)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Activity Logs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="activityLogs form large-9 medium-8 columns content">
    <?= $this->Form->create($activityLog) ?>
    <fieldset>
        <legend><?= __('Edit Activity Log') ?></legend>
        <?php
            echo $this->Form->control('DateAndTime');
            echo $this->Form->control('currentModule');
            echo $this->Form->control('idUser', ['options' => $users]);
            echo $this->Form->control('userAction');
            echo $this->Form->control('message');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
