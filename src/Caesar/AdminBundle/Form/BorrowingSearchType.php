<?php

namespace Caesar\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of ResourceType
 *
 * @author David
 */
class BorrowingSearchType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add("archived", 'checkbox', array('label' => 'form.borrowing.type.label.archived', 'trim' => true, 'required' => false));
    }

    public function getName() {
        return "caesar_adminBundle_borrowingSearchType";
    }

}