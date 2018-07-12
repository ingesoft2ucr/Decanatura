<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityLog $activityLog
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Activity Log'), ['action' => 'edit', $activityLog->idLog]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Activity Log'), ['action' => 'delete', $activityLog->idLog], ['confirm' => __('Are you sure you want to delete # {0}?', $activityLog->idLog)]) ?> </li>
        <li><?= $this->Html->link(__('List Activity Logs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Activity Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="activityLogs view large-9 medium-8 columns content">
    <h3><?= h($activityLog->idLog) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('CurrentModule') ?></th>
            <td><?= h($activityLog->currentModule) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $activityLog->has('user') ? $this->Html->link($activityLog->user->username, ['controller' => 'Users', 'action' => 'view', $activityLog->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UserAction') ?></th>
            <td><?= h($activityLog->userAction) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Message') ?></th>
            <td><?= h($activityLog->message) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('IdLog') ?></th>
            <td><?= $this->Number->format($activityLog->idLog) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('DateAndTime') ?></th>
            <td><?= h($activityLog->DateAndTime) ?></td>
        </tr>
    </table>
</div>
