<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';

// Costumers class
require_once BASE_PATH . '/lib/Players/Players.php';
$players = new Players();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 30;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'lastconnexion';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstanceFivem();
$select = array('identifier', 'firstname', 'lastname', 'accounts', 'job', 'job2', 'firstSpawn', 'lastconnexion');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('firstname', '%' . $search_string . '%', 'like');
	$db->orwhere('lastname', '%' . $search_string . '%', 'like');
	$db->orwhere('identifier', $search_string, '=');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('users', $page, $select);
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

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
foreach ($players->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_by == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>

    <!-- Table -->
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
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'players.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
