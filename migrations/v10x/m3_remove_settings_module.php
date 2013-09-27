<?php
/**
 *
 * @package prefixed
 * @copyright (c) 2013 David King (imkingdavid)
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace imkingdavid\prefixed\migrations\v10x;

/**
 * @ignore
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Because we don't have any settings, we actually don't need a module to
 * manage said settings. Imagine that.
 */
class m3_remove_settings_module extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	public function effectively_installed()
	{
		$sql = 'SELECT module_basename
			FROM ' . MODULES_TABLE . "
			WHERE module_basename = 'prefixed_module'
				AND module_mode = 'settings'";
		$result = $this->db->sql_query($sql);
		$exists = $this->db->sql_fetchfield('basename');
		$this->db->sql_freeresult($result);
		return !$exists;
	}

	/**
	 * @inheritdoc
	 */
	static public function depends_on()
	{
		return array('\imkingdavid\prefixed\migrations\v10x\m2_initial_data');
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return [
			['module.remove', ['acp', 'ACP_PREFIXED_MANAGEMENT', [
					'module_basename'	=> 'prefixed_module',
					'modes'				=> ['settings'],
				]
			]],
		];
	}
}
