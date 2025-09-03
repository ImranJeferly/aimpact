<?php
require_once 'config/database.php';

$search = $_GET['search'] ?? '';

$query = "SELECT * FROM blogs WHERE status = 'published' AND (title LIKE ? OR content LIKE ?)";
$stmt = $pdo->prepare($query);
$stmt->execute(["%$search%", "%$search%"]);
$blogs = $stmt->fetchAll();

if (empty($blogs)): ?>
    <div class="no-results">
        <p>No blog posts found matching "<?php echo htmlspecialchars($search); ?>"</p>
    </div>
<?php else: 
    foreach($blogs as $blog): ?>
        <article class="blog-card fade-hidden fade-from-bottom delay-medium">
            <?php if($blog['image_url']): ?>
                <img src="<?php echo htmlspecialchars($blog['image_url']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-image">
            <?php endif; ?>
            <div class="blog-content">
                <h2><?php 
                    $title = htmlspecialchars($blog['title']);
                    if ($search) {
                        $title = preg_replace("/($search)/i", '<span class="highlight">$1</span>', $title);
                    }
                    echo $title;
                ?></h2>
                <div class="blog-meta">
                    <span class="author-info">
                        <?php 
                            $displayName = match($blog['author']) {
                                'Imran' => 'Ron',
                                'Huseyn' => 'Hudson',
                                'Kamran' => 'Cameron',
                                default => $blog['author']
                            };
                            $authorImage = match($blog['author']) {
                                'Imran' => 'assets/authors/imran.png',
                                'Huseyn' => 'assets/authors/huseyn.png',
                                'Kamran' => 'assets/authors/kamran.png',
                                default => 'assets/authors/default.png'
                            };
                        ?>
                        <img src="<?php echo $authorImage; ?>" alt="<?php echo htmlspecialchars($displayName); ?>" class="author-image">
                        <div class="author-details">
                            <span class="author-name"><?php echo htmlspecialchars($displayName); ?></span>
                            <small>Co-founder of AImpact</small>
                        </div>
                    </span>
                    <div class="meta-right">
                        <span><?php echo date('F j, Y', strtotime($blog['created_at'])); ?></span>
                    </div>
                </div>
                <p class="blog-preview"><?php 
                    $firstSentence = strtok(strip_tags($blog['content']), '.!?');
                    $preview = htmlspecialchars($firstSentence . '.');
                    if ($search) {
                        $preview = preg_replace("/($search)/i", '<span class="highlight">$1</span>', $preview);
                    }
                    echo $preview;
                ?></p>
                <a href="blog.php?id=<?php echo $blog['id']; ?>" class="orange-btn blog-btn">Read More</a>
            </div>
        </article>
    <?php endforeach;
endif; ?>
