<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get DB instance. function is defined in config.php
$db = getDbInstance();
$dbFivem = getDbInstanceFivem();

//Get Dashboard information
$numPlayers = $dbFivem->getValue ("users", "count(*)");

$selectEntreprise = array("count(*)");
$dbFivem->where("name", 'sunnygroupe%', "not like");
$numEntreprises = $dbFivem->arraybuilder()->paginate('jobs', 1, $selectEntreprise)[0]["count(*)"];

$selectGroupes = array("count(*)");
$dbFivem->where("name", 'sunnygroupe%', "like");
$numGroupes = $dbFivem->arraybuilder()->paginate('jobs', 1, $selectGroupes)[0]["count(*)"];

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numPlayers; ?></div>
                            <div>Joueurs</div>
                        </div>
                    </div>
                </div>
                <a href="players.php">
                    <div class="panel-footer">
                        <span class="pull-left">Liste des joueurs</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numEntreprises; ?></div>
                            <div>Entreprises</div>
                        </div>
                    </div>
                </div>
                <a href="entreprises.php">
                    <div class="panel-footer">
                        <span class="pull-left">Liste des Entreprises</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numGroupes; ?></div>
                            <div>Groupes</div>
                        </div>
                    </div>
                </div>
                <a href="groupes.php">
                    <div class="panel-footer">
                        <span class="pull-left">Liste des groupes</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
