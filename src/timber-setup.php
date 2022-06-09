<?php
use Timber\Timber;

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = ['templates'];

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

// Instantiate our theme setup class.
DagLabTheme\TimberSite::instance();
