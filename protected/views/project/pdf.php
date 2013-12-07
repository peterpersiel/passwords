<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div class="container">
    <div id="content">

        <h3>Project</h3>
        <table>
                <tr>
                    <td><strong>ID</strong></td>
                    <td><?php echo $project->id; ?></td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td><?php echo $project->name; ?></td>
                </tr>
                <tr>
                    <td><strong>Client</strong></td>
                    <td><?php echo $project->client; ?></td>
                </tr>
        </table>

        <h3>Passwords</h3>
        <?php if ($project->passwords): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Password</th>
                    <th>Title</th>
                    <th>Username</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($project->passwords as $password): ?>
                <tr>
                    <td><?php echo $password->id; ?></td>
                    <td><?php echo $password->password; ?></td>
                    <td><?php echo $password->title; ?></td>
                    <td><?php echo $password->username; ?></td>
                    <td><?php echo $password->type; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        No Passwords
        <?php endif; ?>
    </div>
    </div>

    <div id="footer">
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>