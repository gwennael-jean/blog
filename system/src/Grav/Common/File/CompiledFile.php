<?php

/**
 * @package    Grav\Common\File
 *
 * @copyright  Copyright (c) 2015 - 2022 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Common\File;

use Exception;
use Grav\Common\Utils;
use RocketTheme\Toolbox\File\PhpFile;
use RuntimeException;
use Throwable;
use function function_exists;
use function get_class;

/**
 * Trait CompiledFile
 * @package Grav\Common\File
 */
trait CompiledFile
{
    /**
     * Get/set parsed file contents.
     *
     * @param mixed $var
     * @return array
     */
    public function content($var = null)
    {
        try {
            // If nothing has been loaded, attempt to get pre-compiled version of the file first.
            if ($var === null && $this->raw === null && $this->content === null) {
                $key = md5($this->filename);
                $file = PhpFile::instance(CACHE_DIR . "compiled/files/{$key}{$this->extension}.php");

                $modified = $this->modified();
                if (!$modified) {
                    try {
                        return $this->decode($this->raw());
                    } catch (Throwable $e) {
                        // If the compiled file is broken, we can safely ignore the error and continue.
                    }
                }

                $class = get_class($this);

                $cache = $file->exists() ? $file->content() : null;

                // Load real file if cache isn't up to date (or is invalid).
                if (!isset($cache['@class'])
                    || $cache['@class'] !== $class
                    || $cache['modified'] !== $modified
                    || $cache['filename'] !== $this->filename
                ) {
                    // Attempt to lock the file for writing.
                    try {
                        $file->lock(false);
                    } catch (Exception $e) {
                        // Another process has locked the file; we will check this in a bit.
                    }

                    // Decode RAW file into compiled array.
                    $data = (array)$this->decode($this->raw());
                    $cache = [
                        '@class' => $class,
                        'filename' => $this->filename,
                        'modified' => $modified,
                        'data' => $data
                    ];

                    // If compiled file wasn't already locked by another process, save it.
                    if ($file->locked() !== false) {
                        $file->save($cache);
                        $file->unlock();

                        // Compile cached file into bytecode cache
                        if (function_exists('opcache_invalidate')) {
                            // Silence error if function exists, but is restricted.
                            @opcache_invalidate($file->filename(), true);
                        }
                    }
                }
                $file->free();

                $this->content = $cache['data'];
            }
        } catch (Exception $e) {
            throw new RuntimeException(sprintf('Failed to read %s: %s', Utils::basename($this->filename), $e->getMessage()), 500, $e);
        }

        return parent::content($var);
    }

    /**
     * Serialize file.
     *
     * @return array
     */
    public function __sleep()
    {
        return [
            'filename',
            'extension',
            'raw',
            'content',
            'settings'
        ];
    }

    /**
     * Unserialize file.
     */
    public function __wakeup()
    {
        if (!isset(static::$instances[$this->filename])) {
            static::$instances[$this->filename] = $this;
        }
    }
}
