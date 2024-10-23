<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$job = filter_input(INPUT_GET, 'job');
if (!empty($job) and !str_starts_with($job, "sunnygroupe")) {
    $db = getDbInstanceFivem();
    $selectjob = array("u.identifier", "u.firstname", "u.lastname", "j.label", "u.lastconnexion");
    $db->join("users u", "u.job_grade=j.grade");
    $db->joinWhere("users u", "u.job = j.job_name");
    $db->where("u.job", $job);
    $db->orderBy("u.job_grade","desc");
    $employes = $db->arraybuilder()->paginate('job_grades j', 1, $selectjob);

    // Set pagination limit
    $db->pageLimit = 30;
    // Get result of the query.
    $employes = $db->arraybuilder()->paginate('users', 1, $select);


    // Nice name for job
    $selectjob = array('label');
    $db->where('name', $job);
    $job_label = $db->arraybuilder()->paginate('jobs', 1, $selectjob)[0]["label"];

    $selectgrade = array('label');
    $db->where('job_name', $job);
    $db->where('grade', $employes[0]["job_grade"]);
    $job_grade = $db->arraybuilder()->paginate('job_grades', 1, $selectjob)[0]["label"];

    $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );

    include BASE_PATH . '/includes/header.php';
    ?>
    <!-- Main container -->
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Joueur : <?php echo xss_clean($row[0]["firstname"] . " " . $row[0]["lastname"]); ?></h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            "u.identifier", "u.firstname", "u.lastname", "j.label", "u.lastconnexion"
            <th width="5%">License</th>
            <th width="5%">Prénom</th>
            <th width="5%">Nom de famille</th>
            <th width="5%">Grade</th>
            <th width="5%">Dernière connexion</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employes as $employe) { ?>
            <tr>
                <td><?php echo xss_clean($employe["identifier"]); ?></td>
                <td><?php echo xss_clean($employe["firstname"]); ?></td>
                <td><?php echo xss_clean($employe["lastname"]); ?></td>
                <td><?php echo xss_clean($employe["label"]); ?></td>
                <td><?php echo xss_clean($employe["lastconnexion"]); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <!-- //Main container -->
    <?php include BASE_PATH . '/includes/footer.php';

} else {
    header('Location: index.php');
}
?>