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

use App\Classes\IServerable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Server
 *
 * @package App\Models\Settings\Emails
 * @property int $id
 * @property string $name
 * @property boolean $enabled
 * @property boolean $delete_original
 * @property string $inbox_name
 * @property boolean $use_archive
 * @property string $archive_name
 * @property-read IServerable serverable
 * @mixin \Eloquent
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
        'name', 'delete_original', 'inbox_name', 'use_archive', 'archive_name'
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

    /**
     * Call the implementation of the obtainEmailsInMailBox from the serverable.
     *
     * @throws \Exception - Various Exceptions may be thrown depending on the underlying implementation of the IServerable interface.
     * @throws \Throwable - Various Throwables may be thrown depending on the underlying implementation of the IServerable interface.
     */
    public function obtainEmails()
    {
        $this->serverable->obtainEmailsInMailBox(
            $this->inbox_name,
            $this->use_archive,
            $this->archive_name);
    }

    /**
     * Sets the enabled field on this Server to the provided state.
     *
     * @param bool $state - True when the Server needs to be enabled, false if otherwise.
     * @throws \Exception - An \Exception thrown when something goes wrong while saving the new state.
     * @throws \Throwable - A \Throwable thrown when something goes wrong while saving the new state.
     */
    public function setEnabled(bool $state = true)
    {
        $this->enabled = $state;
        DB::transaction(function() {
                $this->save();
            }, 3);
    }
}