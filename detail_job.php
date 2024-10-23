<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

$job = filter_input(INPUT_GET, 'job');
if (!empty($job) and !str_starts_with($job, "sunnygroupe")) {

    $db = getDbInstanceFivem();
    $db->pageLimit = 3000;

    $selectjob = array("u.identifier", "u.firstname", "u.lastname", "j.label", "u.lastconnexion", "u.job");
    $db->join("users u", "u.job_grade=j.grade");
    $db->joinWhere("users u", "u.job = j.job_name");
    $db->where("u.job", $job);
    $db->orderBy("u.job_grade","desc");
    $employes = $db->arraybuilder()->paginate('job_grades j', 1, $selectjob);

    $selectjob = array("u.identifier", "u.firstname", "u.lastname", "j.label", "u.lastconnexion", "u.job2");
    $db->join("users u", "u.job_grade=j.grade");
    $db->joinWhere("users u", "u.job2 = j.job_name");
    $db->where("u.job2", $job);
    $db->orderBy("u.job_grade","desc");
    $employes2 = $db->arraybuilder()->paginate('job_grades j', 1, $selectjob);

    $selectcoffre = array("name", "data");
    $db->where("name", 'society_' . $job . '%', "like");
    $coffres = $db->arraybuilder()->paginate('ox_inventory', 1, $selectcoffre);

    // Set pagination limit

    $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );

    include BASE_PATH . '/includes/header.php';
    ?>
    <!-- Main container -->
    <div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Entreprise : <?php echo xss_clean($employes[0]["job"]); ?></h1>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

    <h2>Job principal</h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
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

    <h2>Job secondaire</h2>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
        <tr>
            <th width="5%">License</th>
            <th width="5%">Prénom</th>
            <th width="5%">Nom de famille</th>
            <th width="5%">Grade</th>
            <th width="5%">Dernière connexion</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($employes2 as $employe) { ?>
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

    <h2>Coffres</h2>
    <?php foreach ($coffres as $coffre) { ?>
        <h3><?php echo $coffre["name"]; ?></h3>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th width="5%">Emplacement</th>
                <th width="5%">Item</th>
                <th width="5%">Quantité</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach (json_decode($coffre["data"], true) as $item) { ?>
                <tr>
                    <td><?php echo xss_clean($item["slot"]); ?></td>
                    <td><?php echo xss_clean($item["name"]); ?></td>
                    <td><?php echo xss_clean($item["count"]); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <!-- //Main container -->
    <?php include BASE_PATH . '/includes/footer.php';

} else {
    header('Location: index.php');
}
?>