<?php
require 'config.php';
header("Content-Type: text/xml");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";

$stmt = $pdo->query("SELECT id FROM content WHERE status='publicado'");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<url><loc>" . "http://localhost/view_post.php?id=" . $row['id'] . "</loc></url>\n";
}

echo "</urlset>\n";