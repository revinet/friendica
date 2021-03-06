<?php

namespace Friendica\Module\Search;

use Friendica\Content\Widget;
use Friendica\DI;
use Friendica\Module\BaseSearch;
use Friendica\Module\Security\Login;
use Friendica\Util\Strings;

/**
 * Directory search module
 */
class Directory extends BaseSearch
{
	public static function content(array $parameters = [])
	{
		if (!local_user()) {
			notice(DI::l10n()->t('Permission denied.'));
			return Login::form();
		}

		$search = Strings::escapeTags(trim(rawurldecode($_REQUEST['search'] ?? '')));

		if (empty(DI::page()['aside'])) {
			DI::page()['aside'] = '';
		}

		DI::page()['aside'] .= Widget::findPeople();
		DI::page()['aside'] .= Widget::follow();

		return self::performContactSearch($search);
	}
}
