<?php

namespace Friendica\Module\Admin\Logs;

use Friendica\Core\Renderer;
use Friendica\DI;
use Friendica\Module\BaseAdmin;
use Friendica\Util\Strings;

class View extends BaseAdmin
{
	public static function content(array $parameters = [])
	{
		parent::content($parameters);

		$t = Renderer::getMarkupTemplate('admin/logs/view.tpl');
		$f = DI::config()->get('system', 'logfile');
		$data = '';

		if (!file_exists($f)) {
			$data = DI::l10n()->t('Error trying to open <strong>%1$s</strong> log file.\r\n<br/>Check to see if file %1$s exist and is readable.', $f);
		} else {
			$fp = fopen($f, 'r');
			if (!$fp) {
				$data = DI::l10n()->t('Couldn\'t open <strong>%1$s</strong> log file.\r\n<br/>Check to see if file %1$s is readable.', $f);
			} else {
				$fstat = fstat($fp);
				$size = $fstat['size'];
				if ($size != 0) {
					if ($size > 5000000 || $size < 0) {
						$size = 5000000;
					}
					$seek = fseek($fp, 0 - $size, SEEK_END);
					if ($seek === 0) {
						$data = Strings::escapeHtml(fread($fp, $size));
						while (!feof($fp)) {
							$data .= Strings::escapeHtml(fread($fp, 4096));
						}
					}
				}
				fclose($fp);
			}
		}
		return Renderer::replaceMacros($t, [
			'$title' => DI::l10n()->t('Administration'),
			'$page' => DI::l10n()->t('View Logs'),
			'$data' => $data,
			'$logname' => DI::config()->get('system', 'logfile')
		]);
	}
}
