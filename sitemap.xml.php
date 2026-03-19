<?php
header('Content-Type: application/xml; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate");
$lastmod = date('Y-m-d');
?><?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<url>
<loc>https://www.aora45.com/</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>daily</changefreq>
<priority>1.0</priority>
</url>
<url>
<loc>https://www.aora45.com/rooms</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>weekly</changefreq>
<priority>0.9</priority>
</url>
<url>
<loc>https://www.aora45.com/restaurant</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>weekly</changefreq>
<priority>0.9</priority>
</url>
<url>
<loc>https://www.aora45.com/events</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>https://www.aora45.com/amenities</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>https://www.aora45.com/gallery</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>monthly</changefreq>
<priority>0.7</priority>
</url>
<url>
<loc>https://www.aora45.com/offers</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>weekly</changefreq>
<priority>0.8</priority>
</url>
<url>
<loc>https://www.aora45.com/about</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>monthly</changefreq>
<priority>0.7</priority>
</url>
<url>
<loc>https://www.aora45.com/contact</loc>
<lastmod><?php echo $lastmod; ?></lastmod>
<changefreq>monthly</changefreq>
<priority>0.9</priority>
</url>
</urlset>