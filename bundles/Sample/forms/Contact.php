<?php
namespace Sample\Form;

class Contact
{
    public $storage = [
        'collection'    => 'contacts',
        'key'            => '_id',
    ];
    public $after = 'notice';
    public $notice = 'Your message was saved';

    public function first_nameField()
    {
        return [
            'name'        => 'first_name',
            'placeholder' => 'First Name',
            'display'    => 'InputText',
            'required'    => true
        ];
    }

    public function last_nameField()
    {
        return [
            'name'        => 'last_name',
            'placeholder' => 'Last Name',
            'label'        => 'Last Name',
            'display'    => 'InputText',
            'required'    => true
        ];
    }

    public function phoneField()
    {
        return [
            'name'        => 'phone',
            'placeholder'    => 'Phone',
            'display'    => 'InputText',
            'required'    => true
        ];
    }

    public function emailField()
    {
        return [
            'name'        => 'email',
            'placeholder'        => 'Email Address',
            'display'    => 'InputText',
            'required'    => true
        ];
    }

    public function messageField()
    {
        return [
            'name'        => 'message',
            'placeholder'        => 'Enter your message here',
            'display'    => 'Textarea',
            'required'    => true
        ];
    }
}
