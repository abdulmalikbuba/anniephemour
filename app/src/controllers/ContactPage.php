<?php

use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Control\Email\Email;


class ContactPageController extends PageController
{
    private static $allowed_actions = ['ContactForm', 'handleContactForm'];

    public function ContactForm()
    {
        $fields = FieldList::create(
            CompositeField::create(
                TextField::create('Name', 'Your Name')
                    ->setAttribute('class', 'form-control mb-3')
                    ->setAttribute('id', 'floatingInputName')
                    ->addExtraClass('col-lg-6')
                    ->setFieldHolderTemplate('Forms/BootstrapFormFieldHolder'),
                EmailField::create('Email', 'Your Email')
                    ->setAttribute('class', 'form-control mb-3')
                    ->setAttribute('id', 'floatingInputEmail')
                    ->addExtraClass('col-lg-6')
                    ->setFieldHolderTemplate('Forms/BootstrapFormFieldHolder')
            )->addExtraClass('row')->setFieldHolderTemplate('Forms/BootstrapCompositeFieldHolder'),
            TextField::create('Subject', 'Subject')
                ->setAttribute('class', 'form-control mb-3')
                ->setAttribute('id', 'floatingInputSubject'),
            TextareaField::create('Message', 'Message')
                ->setAttribute('class', 'form-control mb-3')
                ->setAttribute('placeholder', 'Your message here')
                ->setAttribute('maxlength', 500)
                ->setAttribute('id', 'floatingInputMessage')
        );

        $actions = FieldList::create(
            FormAction::create('handleContactForm', 'Submit')
                ->addExtraClass('btn btn-warning')
        );

        $validator = RequiredFields::create('Name', 'Email', 'Subject', 'Message');

        return Form::create($this, 'ContactForm', $fields, $actions, $validator)
            ->addExtraClass('wow fadeInUp')
            ->setAttribute('data-wow-delay', '0.3s');
    }

    public function handleContactForm($data, Form $form, HTTPRequest $request)
    {
        // Handle form submission
        $name = $data['Name'];
        $email = $data['Email'];
        $subject = $data['Subject'];
        $message = $data['Message'];

        // Perform your logic here, e.g., send an email, save to the database, etc.
        $submission = ContactSubmission::create();
        $form->saveInto($submission);
        $submission->write();
        
        // Prepare and send email
        // $to = 'abdulmalikabubakar273@gmail.com'; // Replace with your email address
        // $from = $email;
        // $email = Email::create()
        //     ->setTo($to)
        //     ->setFrom($from)
        //     ->setSubject($subject)
        //     ->setBody(
        //         "Name: $name\n" .
        //         "Email: $email\n" .
        //         "Message:\n$message"
        //     );

        // // Attempt to send the email
        // try {
        //     $email->send();
        //     $form->sessionMessage('Your message has been sent successfully.', 'good');
        // } catch (Exception $e) {
        //     $form->sessionMessage('There was an error sending your message. Please try again later.', 'bad');
        // }
           

        // Provide feedback to the user
        $form->sessionMessage('Your message has been sent successfully.', 'good');

        // Redirect back to the form
        return $this->redirectBack();
    }
}