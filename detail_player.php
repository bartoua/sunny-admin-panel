<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$identifier = filter_input(INPUT_GET, 'identifier');
if (!empty($identifier)) {
    $db = getDbInstanceFivem();
    $pagelimit = 30;
    $select = array('identifier', 'firstname', 'lastname', 'accounts', 'job', 'job_grade', 'job2', 'job2_grade',
        'group', 'dateofbirth', 'sex', 'vote', 'have_bracelet', 'matricule', 'firstSpawn', 'lastconnexion');
    if ($identifier) {
        $db->where('firstname', $identifier , '=');
    }

    // Get result of the query.
    $row = $db->arraybuilder();
var_dump($row);
die();
    include BASE_PATH . '/includes/header.php';
    ?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th width="5%">Licence</th>
        <th width="20%">Nom</th>
        <th width="20%">Comptes</th>
        <th width="20%">Jobs</th>
        <th width="10%">Age du perso</th>
        <th width="10%">Dernière connexion</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row): ?>
        <tr>
            <td><?php echo $row['identifier']; ?></td>
            <td><?php echo xss_clean($row['firstname'] . ' ' . $row['lastname']); ?></td>
            <td><?php echo xss_clean($row['accounts']); ?></td>
            <td><?php echo xss_clean($row['job'] . " / " . $row['job2']); ?></td>
            <td><?php echo xss_clean($row['firstSpawn']); ?></td>
            <td><?php echo xss_clean($row['lastconnexion']); ?></td>
            <td>
                <a href="detail_player.php?identifier=<?php echo $row['identifier']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
            </td>
        </tr>
        <!-- //Delete Confirmation Modal -->
    <?php endforeach;?>
    </tbody>
</table>

    <!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>

} else {
    header('Location: index.php');
}