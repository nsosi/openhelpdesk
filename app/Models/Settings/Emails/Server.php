<?php
/**
 * An Eloquent model describing settings used for an e-mail server.
 * Is the target for morphTo relations from models that provide more specific settings for the target protocol.
 * For example: IMAP.
 *
 * @since 0.1
 * @author Chris van Zanten <c.vanzanten@nsosi.com>
 * @copyright 2018 North Sea Open Source Initiative (www.nsosi.com)
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace App\Models\Settings\Emails;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 *
 * @package App\Models\Settings\Emails
 * @property int id
 * @property string name
 * @property boolean delete_original
 */
class Server extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings_emails_servers';

    /**
     * No timestamps are used with this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'delete_original'
    ];

    /**
     * Obtain the serverable that morphs to this App\Models\Settings\Emails\Server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function serverable()
    {
        return $this->morphTo('serverable');
    }
}