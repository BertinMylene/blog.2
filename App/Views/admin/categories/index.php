<h1>Administration</h1>

<table class="table">
    <thead>
        <tr>
            <td>ID</td>
            <td>Titre</td>
            <td>Actions</td>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($categories as $category) : ?>
        <tr>
            <td><?= $category->id; ?></td>
            <td><?= $category->name; ?></td>
            <td>
                <a href="<?= $category->modifyURL; ?>" class="btn btn-primary">Modifier</a>
                <form action="index.php?p=admin.categories.delete" method="post" style="display:inline;">
                    <?= $this->form->input('id', '', ['type' => 'hidden', 'data' => $category->id]); ?>
                    <?= $this->form->submit('Supprimer', 'btn btn-danger'); ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><a href="index.php?p=admin.categories.add" class="btn btn-primary">Ajouter une nouvelle catégorie</a></p>
</table>
