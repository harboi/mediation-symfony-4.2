<?php
/**
 * Created by PhpStorm.
 * User: blob
 * Date: 21/11/2015
 * Time: 01:54
 */

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

class PublicationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('publishedAt', DateType::class, array(
            'input'  => 'datetime',
            'widget' => 'choice',
            'label' => 'Date publication',
        ));

        $builder->add('title', TextType::class,
            array('label' => 'Titre', 'attr' => [], 'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('max'  => 200)))));

        $builder->add('content', TextareaType::class,
            array('label' => 'Texte', 'attr' => ['style' => 'height:400px;'], 'constraints' => array(new Assert\NotBlank())));

        $builder->add('submit', SubmitType::class,
            array('label' => 'Envoyer', 'attr' => array('class' => 'btn-primary btn-lg')));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }

    public function getName()
    {
        return 'form_publication';
    }
}