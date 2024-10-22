<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$identifier = filter_input(INPUT_GET, 'identifier');
if (!empty($identifier)) {
    $db = getDbInstanceFivem();
    $select = array('identifier', 'firstname', 'lastname', 'accounts', 'job', 'job_grade', 'job2', 'job2_grade',
        '`group`', 'dateofbirth', 'sex', 'vote', 'have_bracelet', 'matricule', 'firstSpawn', 'lastconnexion');
    if ($identifier) {
        $db->where('identifier', $identifier , '=');
    }

    // Set pagination limit
    $db->pageLimit = 1;
    // Get result of the query.
    $row = $db->arraybuilder()->paginate('users', 1, $select);
    $total_pages = $db->totalPages;

    include BASE_PATH . '/includes/header.php';
    ?>
    <!-- Main container -->
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Joueurs</h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

<table class="table table-striped table-bordered table-condensed">
    <thead>
    <tr>
        <th width="5%">Clef</th>
        <th width="20%">Valeur</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($row as $k => $v): ?>
        <tr>
            <td><?php echo xss_clean($row['$k']); ?></td>
            <td><?php echo xss_clean($row['$v']); ?></td>
        </tr>
        <!-- //Delete Confirmation Modal -->
    <?php endforeach;?>
    </tbody>
</table>

    <!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';

} else {
    header('Location: index.php');
}
?>