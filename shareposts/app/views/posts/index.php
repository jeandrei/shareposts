<?php require APPROOT . '/views/inc/header.php'; ?>
<!-- post_message é o nome da menságem está lá no controller -->
<?php flash('post_message'); ?>
<!-- mb-3 marging bottom -->
<div class="row mb-3">
    <div class="col-md-6">
        <h1>Postagens</h1>
    </div>
    <div class="col-md-6">
        <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
            <i class="fa fa-pencil"></i> Adicionar Postagem
        </a>
    </div>
</div>

<?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $post->title; ?></h4>
        <div class="bg-light p-2 mb-3">
          Escrito por <?php echo $post->name; ?> em <?php echo date('d/m/Y h:i:s', strtotime($post->postCreated)); ?>
        </div>
        <p class="card-text"><?php echo $post->body; ?></p>
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">
        Mais</a>
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>

