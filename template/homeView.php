<!-- Main Content -->
<?php foreach ($articles as $data): ?>
    <!--Content index Page-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-preview">
                    <a href="/articleDetailsView/<?= $data['id']?>" target="_blank">
                        <h2 class="post-title">
                            <?= htmlspecialchars($data->getTitle()); ?>
                        </h2>
                        <h3 class="post-subtitle">
                            <?= htmlspecialchars($data['chapo']) ?>
                        </h3>
                    </a>
                    <p class="post-meta">Posté par
                        <a><?= htmlspecialchars($data['pseudo']) ?></a>
                        le <?= htmlspecialchars($data['creation_date_fr']) ?></p>
                </div>
            </div>
        </div>
    <div class="col-lg-8 col-md-10 mx-auto clearfix">
        <a class="btn btn-primary float-left" href="/articleDetailsView/<?= $data['id']?>" target="_blank">Voir les commentaires</a>
    </div>
    </div>

    <hr>
<?php endforeach; ?>