<?php

namespace App\Services;

use RuntimeException;

/** A CMS upload could not be stored; the record keeps its current files. */
class MediaUploadFailed extends RuntimeException
{
    /** Send the admin back to the form with the existing error banner instead of a server error page. */
    public function render()
    {
        return back()->withInput()->with('error', $this->getMessage() . ' The existing file has been kept. Please try again.');
    }
}
