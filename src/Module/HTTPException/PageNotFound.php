<?php

namespace Friendica\Module\HTTPException;

use Friendica\BaseModule;
use Friendica\DI;
use Friendica\Network\HTTPException;

class PageNotFound extends BaseModule
{
	public static function content(array $parameters = [])
	{
		throw new HTTPException\NotFoundException(DI::l10n()->t('Page not found.'));
	}
}
