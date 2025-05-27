<?php
include 'includes/config.php';
include 'includes/header.php';
include 'includes/footer.php';

// Determina il progetto da mostrare (default: 1 se non specificato)
$project = isset($_GET['project']) ? (int)$_GET['project'] : 1;
if ($project < 1 || $project > 6) {
    $project = 1; // Limita a valori validi (1-6)
}

// Calcola gli ID del progetto (ogni progetto ha 2 elementi)
$start_id = ($project - 1) * 2 + 1; // Es. project=1 -> id 1, project=2 -> id 3
$end_id = $start_id + 1;             // Es. project=1 -> id 2, project=2 -> id 4

// Leggi il JSON
$json = file_get_contents('json_data/dati_lavori.json');
if ($json === false) {
    $json_data = [];
    $error = "Errore nel caricamento dei dati.";
} else {
    $json_data = json_decode($json, true);
    if ($json_data === null) {
        $json_data = [];
        $error = "Errore nella decodifica dei dati.";
    }
}

// Filtra il progetto principale (primo ID della coppia)
$item = array_filter($json_data, fn($riga) => $riga['id'] == $start_id);
$item = reset($item) ?: null;

// Filtra la galleria (entrambi gli ID della coppia)
$gallery_items = array_filter($json_data, fn($riga) => $riga['id'] == $start_id || $riga['id'] == $end_id);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($item ? $item['title'] . ' - ' . $site_name : $site_name); ?></title>
    <?php includeCSS($dettaglilavoro_css); ?>
</head>
<body>
    <?php renderHeader($site_name, $menu_items); ?>

    <!-- Sfondo -->
    <section class="sfondo">
        <div class="sfondo-content">
            <h2><?= $item ? htmlspecialchars($item['title']) : 'Progetto non trovato'; ?></h2>
        </div>
    </section>

    <!-- Servizi -->
    <section class="services">
        <div class="container">
            <div class="service-item">
                <div class="service-title">
                    <h3><?= $item ? htmlspecialchars($item['tipo']) : 'N/A'; ?></h3>
                </div>
                <div class="service-description">
                    <p><?= $item ? htmlspecialchars($item['description']) : 'Descrizione non disponibile'; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galleria -->
    <div class="image-gallery">
        <?php if (empty($gallery_items)): ?>
            <p>Nessuna immagine disponibile per questo progetto.</p>
        <?php else: ?>
            <?php foreach ($gallery_items as $image): ?>
                <div class="gallery-item">
                    <img
                        src="<?= htmlspecialchars($image['src']); ?>"
                        title="<?= htmlspecialchars($image['title']); ?>"
                        alt="<?= htmlspecialchars($image['alt']); ?>"
                        loading="lazy">
                    <div class="project-name"><?= htmlspecialchars($image['title']); ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (isset($error)): ?>
        <p class="error"><?= $error; ?></p>
    <?php endif; ?>

    <?php renderFooter($current_year, $site_name); ?>
</body>
</html>