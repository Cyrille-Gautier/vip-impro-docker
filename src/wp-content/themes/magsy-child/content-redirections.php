<!-- content-redirection-->
<?php
if(isset( $_SESSION['flashbags']['redirections'] ) && count( $_SESSION['flashbags']['redirections'] )>0 ) { 
	foreach ($_SESSION['flashbags']['redirections'] as $nflashbag=>$flashbag ) { ?>
<div class="alert <?php echo $flashbag['class']; ?> alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <?php echo $flashbag['message'];  ?>
</div>
<?php } 
	unset($_SESSION['flashbags']['redirections']);
} ?>
<table class="table table-hover info-price">
  <thead>
    <tr>
      <th>Groupe</th>
      <th>Target</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <form action="" method="post">
    <tr>
      <td><input type="text" value="" name="local" class="form-control" placeholder="préfixe de l'alias" /></td>
      <td><input type="text" value="" name="target" class="form-control" placeholder="cible de l'alias (email)" /></td>
      <td><input type="submit" class="btn btn-default" value="ajouter" onclick="if(!window.confirm('Etes-vous sûr de vouloir créer cet alias ? Toute saisie d\'email erroné supprimera cet alias.')) return false;"/><input type="hidden" name="action" value="ajouter" /></td>
    </tr>
    </form>
  </tbody>
</table>

<div class="clearfix"></div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php 
	$ngroupe=0;
	foreach( $liste_redirections as $groupe=>$redirections ) {
		?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $groupe; ?>" aria-expanded="true" aria-controls="collapse<?php echo $groupe; ?>"><?php echo $groupe; ?> <span class="badge"><?php echo count($redirections); ?></span></a>
      </h4>
    </div>
    <div id="collapse<?php echo $groupe; ?>" class="panel-collapse collapse <?php if ( isset($_SESSION['redirections']['selected']) && $_SESSION['redirections']['selected']==$_POST['local'] ) { echo "in"; } else if ($ngroupe==0) { echo "in";  } ?>" role="tabpanel" aria-labelledby="heading<?php echo $groupe; ?>">
    <div class="panel-body">
              
<table class="table table-hover info-price">
  <thead>
    <tr>
      <th>Groupe</th>
      <th>Target</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php
	  $nligne=0;
	  foreach ($redirections as $nredirection=>$redirection) {
	?>
    <form action="" method="post">
    <tr>
      <td><input type="text" value="<?php echo $redirection->local; ?>" name="local" class="form-control" /></td>
      <td><input type="text" value="<?php echo $redirection->target; ?>" name="target" class="form-control" /><input type="hidden" value="<?php echo $redirection->target; ?>" name="oldtarget" /></td>
      <td>
          <button type="submit" class="button" value="modifier" onclick="if(!window.confirm('Etes-vous sûr de vouloir modifier cet alias ? Toute saisie d\'email erroné supprimera cet alias.')) return false;">Modifier</button>
          <button type="submit" class="button secondary" onclick="if(!window.confirm('Etes-vous sûr de vouloir supprimer cet alias ? ')) { return false } else { document.getElementById('action<?php echo $redirection->local.$nredirection; ?>').value='supprimer' };"><i class="mdi mdi-delete"></i></button>
          <input type="hidden" name="action" id="action<?php echo $redirection->local.$nredirection; ?>" value="modifier" /></td>
    </tr>
    </form>
    <?php 
		$nligne++;
	  }
	?>
  </tbody>
</table>
    </div>
    </div>
  </div>
    <?php
	$ngroupe++;
  } ?>
</div>
