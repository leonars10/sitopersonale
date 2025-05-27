<?php
include 'includes/config.php';
include 'includes/header.php';
include 'includes/footer.php';
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name); ?></title>
    <?php includeCSS($lavori_css); ?> 
</head>

<body>

<?php renderHeader($site_name, $menu_items); ?>



<?php
// Read the JSON file
$json_video = file_get_contents('json_data/dati_lavori_video.json'); 

// Check if the file was read successfully
if ($json_video === false) {
    die('Error reading the JSON file');
}

// Decode the JSON file
$json_data_video = json_decode($json_video, true); 

// Check if the JSON was decoded successfully
if ($json_data_video === null) {
    die('Error decoding the JSON file');
}

?>

<!-- Sfondo -->
<section class="sfondo">
    <div class="sfondo-content">
        <h2>Lavori eseguiti</h2>
    </div>
</section>

<section class="video-section">
    <div class="video-container">
        <video controls autoplay>  <?php foreach ($json_data_video as $item) { if ($item["id"] == 1 ) { echo "<source src='{$item['src']}' title='{$item['title']}' type='{$item['type']}'>"; }} ?>
        </video>
    </div>
</section>

<!-- Progetti -->

<div class="projects-container">
<?php
// Read the JSON file
$json = file_get_contents('json_data/dati_lavori.json'); 

// Check if the file was read successfully
if ($json === false) {
    die('Error reading the JSON file');
}

// Decode the JSON file
$json_data = json_decode($json, true); 

// Check if the JSON was decoded successfully
if ($json_data === null) {
    die('Error decoding the JSON file');
}

// Filtra gli ID dispari
$oddIds = array_filter($json_data, function($item) {
    // Verifica se esiste la chiave 'id' ed è dispari
    return isset($item['id']) && ($item['id'] % 2 !== 0);
});

?>



<?php foreach ($oddIds as $project): ?>
        <div class="project-item">
            <a href="<?= htmlspecialchars($project['link']); ?>" title="<?= htmlspecialchars($project['title']); ?>">
                <div class="project-image">
                    <img 
                        src="<?= htmlspecialchars($project['image']); ?>" 
                        alt="<?= htmlspecialchars($project['title']); ?>" 
                        loading="lazy">
                </div>
                <div class="project-name"><?= htmlspecialchars($project['title']); ?></div>
            </a>
        </div>
    <?php endforeach; ?>
</div> 


<?php
renderFooter($current_year, $site_name);
?>

</body> 
</html>
