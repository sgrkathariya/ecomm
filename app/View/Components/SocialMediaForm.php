<?php

namespace App\View\Components;

use App\SocialMedia;
use Illuminate\View\Component;

class SocialMediaForm extends Component
{
    public $socialMedia;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SocialMedia $socialmedia)
    {
        $this->socialMedia = $socialmedia;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $socialMedias = SocialMedia::get();
        return view('components.social-media-form', compact('socialMedias'));
    }
}
