<?php namespace App\Twig;

use Twig\TwigFilter;

class Extension extends \Twig\Extension\AbstractExtension {

	public function getFilters() {
		return [
			new TwigFilter('format_content', [$this, 'formatContent']),
		];
	}

	public function formatContent($content) {
		$content = '<p>'.str_replace("\n", '</p><p>', $content).'</p>';
		$content = preg_replace('#__([^_]+)__#', '<b>$1</b>', $content);
		$content = preg_replace('#_([^_]+)_#', '<i>$1</i>', $content);
		$content = strtr($content, [
			'`' => '&#768;',
		]);
		return $content;
	}
}
