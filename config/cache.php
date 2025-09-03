<?php
/**
 * Simple file-based caching system
 */

class SimpleCache {
    private $cacheDir;
    
    public function __construct($cacheDir = 'cache') {
        $this->cacheDir = $cacheDir;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0755, true);
        }
    }
    
    public function get($key) {
        $file = $this->getCacheFile($key);
        if (!file_exists($file)) {
            return null;
        }
        
        $data = unserialize(file_get_contents($file));
        
        // Check if expired
        if ($data['expires'] < time()) {
            unlink($file);
            return null;
        }
        
        return $data['value'];
    }
    
    public function set($key, $value, $ttl = 300) { // 5 minutes default
        $file = $this->getCacheFile($key);
        $data = [
            'value' => $value,
            'expires' => time() + $ttl
        ];
        
        return file_put_contents($file, serialize($data)) !== false;
    }
    
    public function delete($key) {
        $file = $this->getCacheFile($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }
    
    private function getCacheFile($key) {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}

// Global cache instance
$cache = new SimpleCache();
?>