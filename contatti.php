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
    <?php includeCSS($contatti_css); ?> 
</head>

<body>

<?php renderHeader($site_name, $menu_items); ?>


<?php
// Read the JSON file
$json = file_get_contents('json_data/dati_chi_sono.json'); 

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

$righeDesiderate = array_filter($json_data, function($riga) {
    return $riga['id'] == 1 ; 
 });


?>


<!-- Sfondo -->
<section class="sfondo">
    <div class="sfondo-content">
        <?php foreach ($json_data as $item) { if ($item["id"] == 1 ) { echo "<h2>{$item['title']}</h2>"; } }  ?>
    </div>
</section>

<section class="image-gallery">
    <?php 
    $images = [
        ["src" => "Immagini_Lavoro/Chisono1.jpg", "title" => "Chi sono", "alt" => "Immagine 1"]
    ];

    foreach ($images as $image): ?>
        <div class="gallery-item">
            <img 
                src="<?= htmlspecialchars($image['src']); ?>" 
                title="<?= htmlspecialchars($image['title']); ?>" 
                alt="<?= htmlspecialchars($image['alt']); ?>">
            <div class="project-name"><?= htmlspecialchars($image['title']); ?></div>
        </div>
    <?php endforeach; ?>
</section>

<!-- Servizi -->

<section class="services">
    <div class="container">
       <?php foreach ($json_data as $item) { if ($item["id"] == 1 ) { echo "<h2>{$item['articolo']}</h2>"; } }  ?>
            <div class="service-item">
                <?php foreach ($json_data as $item) { if ($item["id"] == 1 ) { echo "<p>{$item['description']}</p>"; } }  ?>
            </div>
    </div>
</section>



<?php include 'includes/contact_form.php'; ?>


<?php
renderFooter($current_year, $site_name);
?>
</body>
</html>