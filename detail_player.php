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

    $fmt = numfmt_create( 'en_US', NumberFormatter::CURRENCY );

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
        <th width="5%">Editer/Détail</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>License</td>
        <td><?php echo xss_clean($row[0]["identifier"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Prénom</td>
        <td><?php echo xss_clean($row[0]["firstname"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Nom de famille</td>
        <td><?php echo xss_clean($row[0]["lastname"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Argent liquide</td>
        <td><?php echo xss_clean(numfmt_format_currency($fmt,json_decode($row[0]["accounts"], true)["money"]), "$"); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Argent sale</td>
        <td><?php echo xss_clean(json_decode($row[0]["accounts"], true)["black_money"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Compte en banque</td>
        <td><?php echo xss_clean(json_decode($row[0]["accounts"], true)["bank"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Métier principal</td>
        <td><?php echo xss_clean($row[0]["job"] . " / " . $row[0]["job_grade"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Métier secondaire</td>
        <td><?php echo xss_clean($row[0]["job2"] . " / " . $row[0]["job2_grade"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Grade staff</td>
        <td><?php echo xss_clean($row[0]["group"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Date de naissance</td>
        <td><?php echo xss_clean($row[0]["dateofbirth"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Sexe</td>
        <td><?php echo xss_clean(($row[0]["sex"] == "M" ? "Homme" : "Femme")); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Vote</td>
        <td><?php echo xss_clean($row[0]["vote"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Bracelet</td>
        <td><?php echo xss_clean(($row[0]["have_bracelet"] == 0 ? "Oui" : "Non")); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Matricule</td>
        <td><?php echo xss_clean($row[0]["matricule"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Création du personnage</td>
        <td><?php echo xss_clean($row[0]["firstSpawn"]); ?></td>
        <td>Coucou</td>
    </tr>
    <tr>
        <td>Dernière connexion</td>
        <td><?php echo xss_clean($row[0]["lastconnexion"]); ?></td>
        <td>Coucou</td>
    </tr>
    </tbody>
</table>

    <!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';

} else {
    header('Location: index.php');
}
?>