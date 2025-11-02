<?php

// Set the project root directory - adjust this path if needed
$rootPath = __DIR__;
$projectName = basename($rootPath);

// Get the requested path from query string or default to root
$requestPath = isset($_GET['path']) ? $_GET['path'] : '';
$currentPath = realpath($rootPath . '/' . $requestPath);

// Security check - make sure we're still within the project directory
if (!$currentPath || strpos($currentPath, $rootPath) !== 0) {
    $currentPath = $rootPath;
    $requestPath = '';
}

// Get the parent directory
$parentPath = dirname($requestPath);
if ($parentPath == '.') {
    $parentPath = '';
}

// Function to get file size in human-readable format
function formatSize($bytes)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $i = 0;
    while ($bytes >= 1024 && $i < count($units) - 1) {
        $bytes /= 1024;
        $i++;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}

// Get directory contents
$items = [];
if (is_dir($currentPath)) {
    if ($handle = opendir($currentPath)) {
        while (($entry = readdir($handle)) !== false) {
            if ($entry != "." && $entry != ".." && $entry != "file-explorer.php") {
                $fullPath = $currentPath . DIRECTORY_SEPARATOR . $entry;
                $relativePath = $requestPath ? $requestPath . '/' . $entry : $entry;

                $items[] = [
                    'name' => $entry,
                    'path' => $relativePath,
                    'is_dir' => is_dir($fullPath),
                    'size' => is_file($fullPath) ? formatSize(filesize($fullPath)) : '-',
                    'modified' => date('Y-m-d H:i:s', filemtime($fullPath))
                ];
            }
        }
        closedir($handle);
    }
}

// Sort items - directories first, then alphabetically
usort($items, function ($a, $b) {
    if ($a['is_dir'] && !$b['is_dir'])
        return -1;
    if (!$a['is_dir'] && $b['is_dir'])
        return 1;
    return strcasecmp($a['name'], $b['name']);
});

// Get breadcrumbs
$breadcrumbs = [];
$breadcrumbs[] = ['name' => $projectName, 'path' => ''];

if ($requestPath) {
    $parts = explode('/', $requestPath);
    $currentBreadcrumb = '';

    foreach ($parts as $part) {
        $currentBreadcrumb .= ($currentBreadcrumb ? '/' : '') . $part;
        $breadcrumbs[] = [
            'name' => $part,
            'path' => $currentBreadcrumb
        ];
    }
}

// Get the relative path for display
$displayPath = $requestPath ? $requestPath : '/';

// Set content type
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Explorer - <?php echo htmlspecialchars($displayPath); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        .file-explorer {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .explorer-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .breadcrumb {
            margin-bottom: 0;
            background: transparent;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }

        .file-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #f1f1f1;
            transition: background-color 0.2s;
        }

        .file-item:hover {
            background-color: #f8f9fa;
        }

        .file-icon {
            font-size: 1.2rem;
            width: 30px;
            text-align: center;
            margin-right: 10px;
        }

        .dir-icon {
            color: #ffc107;
        }

        .file-icon.code {
            color: #007bff;
        }

        .file-icon.image {
            color: #28a745;
        }

        .file-icon.document {
            color: #6c757d;
        }

        .file-name {
            flex-grow: 1;
            font-weight: 500;
        }

        .file-name a {
            text-decoration: none;
            color: inherit;
        }

        .file-name a:hover {
            text-decoration: underline;
        }

        .file-info {
            color: #6c757d;
            font-size: 0.9rem;
            margin-left: 10px;
            min-width: 100px;
            text-align: right;
        }

        .file-date {
            color: #6c757d;
            font-size: 0.9rem;
            min-width: 180px;
            text-align: right;
        }

        .search-box {
            max-width: 300px;
        }

        @media (max-width: 768px) {
            .file-date {
                display: none;
            }
        }

        .quick-links {
            padding: 10px 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }

        .quick-links a {
            display: inline-block;
            margin-right: 10px;
            padding: 5px 10px;
            border-radius: 4px;
            background: #e9ecef;
            text-decoration: none;
            color: #212529;
            font-size: 0.9rem;
        }

        .quick-links a:hover {
            background: #dee2e6;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="file-explorer">
            <div class="explorer-header">
                <h4 class="mb-0">Project Explorer</h4>
                <div class="search-box">
                    <input type="text" class="form-control" id="searchInput" placeholder="Search files...">
                </div>
            </div>

            <div class="quick-links">
                <strong>Quick Access:</strong>
                <a href="?path=app/Http/Controllers"><i class="fas fa-code me-1"></i>Controllers</a>
                <a href="?path=resources/views"><i class="fas fa-file-code me-1"></i>Views</a>
                <a href="?path=public/assets/images"><i class="fas fa-images me-1"></i>Images</a>
                <a href="?path=database/migrations"><i class="fas fa-database me-1"></i>Migrations</a>
                <a href="?path=routes"><i class="fas fa-route me-1"></i>Routes</a>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb p-3 bg-light">
                    <?php foreach ($breadcrumbs as $i => $crumb): ?>
                        <?php if ($i === count($breadcrumbs) - 1): ?>
                            <li class="breadcrumb-item active"><?php echo htmlspecialchars($crumb['name']); ?></li>
                        <?php else: ?>
                            <li class="breadcrumb-item">
                                <a
                                    href="?path=<?php echo urlencode($crumb['path']); ?>"><?php echo htmlspecialchars($crumb['name']); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ol>
            </nav>

            <ul class="file-list" id="fileList">
                <?php if ($requestPath): ?>
                    <li class="file-item">
                        <div class="file-icon dir-icon">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="file-name">
                            <a href="?path=<?php echo urlencode($parentPath); ?>">..</a>
                        </div>
                        <div class="file-info"></div>
                        <div class="file-date"></div>
                    </li>
                <?php endif; ?>

                <?php foreach ($items as $item): ?>
                    <li class="file-item">
                        <div
                            class="file-icon <?php echo $item['is_dir'] ? 'dir-icon' : getFileIconClass($item['name']); ?>">
                            <i class="fas <?php echo $item['is_dir'] ? 'fa-folder' : getFileIcon($item['name']); ?>"></i>
                        </div>
                        <div class="file-name">
                            <?php if ($item['is_dir']): ?>
                                <a href="?path=<?php echo urlencode($item['path']); ?>">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($item['path']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="file-info"><?php echo htmlspecialchars($item['size']); ?></div>
                        <div class="file-date"><?php echo htmlspecialchars($item['modified']); ?></div>
                    </li>
                <?php endforeach; ?>

                <?php if (empty($items)): ?>
                    <li class="file-item text-center py-4 text-muted">
                        <em>This folder is empty</em>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <script>
        // Simple client-side search functionality
        document.getElementById('searchInput').addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            const fileItems = document.querySelectorAll('#fileList .file-item');

            fileItems.forEach(item => {
                const fileName = item.querySelector('.file-name').textContent.toLowerCase();
                if (fileName === '..') {
                    item.style.display = 'flex';  // Always show parent directory link
                } else if (searchTerm === '' || fileName.includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>

<?php
// Helper function to determine file icon based on extension
function getFileIcon($filename)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    switch (strtolower($ext)) {
        case 'php':
        case 'js':
        case 'css':
        case 'html':
        case 'blade.php':
            return 'fa-code';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        case 'svg':
        case 'webp':
            return 'fa-image';
        case 'pdf':
            return 'fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fa-file-word';
        case 'xls':
        case 'xlsx':
            return 'fa-file-excel';
        case 'md':
        case 'txt':
            return 'fa-file-alt';
        case 'zip':
        case 'rar':
        case 'tar':
        case 'gz':
            return 'fa-file-archive';
        default:
            return 'fa-file';
    }
}

function getFileIconClass($filename)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    switch (strtolower($ext)) {
        case 'php':
        case 'js':
        case 'css':
        case 'html':
        case 'blade.php':
            return 'code';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
        case 'svg':
        case 'webp':
            return 'image';
        default:
            return 'document';
    }
}
?>