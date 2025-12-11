<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header('Location: index.php');
    exit();
}
// In a real app, this would be loaded from a config file or database
$homepage_sections = [
    ['id' => 'hero_carousel', 'name' => 'Hero Carousel', 'is_enabled' => true, 'order' => 1],
    ['id' => 'flash_sales', 'name' => 'Flash Sales', 'is_enabled' => true, 'order' => 2],
    ['id' => 'best_sellers', 'name' => 'Best Sellers', 'is_enabled' => true, 'order' => 3],
    ['id' => 'new_arrivals', 'name' => 'New Arrivals', 'is_enabled' => false, 'order' => 4],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Manager</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <header class="admin-header">
        <h1>Homepage Manager</h1>
        <nav class="admin-nav"><a href="dashboard.php">Dashboard</a></nav>
    </header>

    <main class="admin-main">
        <p>Drag and drop to reorder sections. Use checkboxes to enable or disable them.</p>
        <!-- Form and logic to save changes will be added -->
        <ul id="section-list">
            <?php foreach($homepage_sections as $section): ?>
                <li data-id="<?= $section['id'] ?>">
                    <span><?= $section['name'] ?></span>
                    <input type="checkbox" <?= $section['is_enabled'] ? 'checked' : '' ?>>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
</body>
</html>
