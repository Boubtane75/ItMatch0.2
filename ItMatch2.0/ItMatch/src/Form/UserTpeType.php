<?php

namespace App\Form;

use App\Entity\Cars;
use App\Entity\Utilisateur;
use App\Form\CarType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserTpeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('imageFile',FileType::class, [
                'required' => false
            ])
            ->add('email')
            ->add('phone')
            ->add('pays')
            ->add('car',EntityType::class,[
                'class' => Cars::class,
                'choice_label' => 'model'
            ])
            ->add('ville')
            ->add('adress')
            ->add('password',PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
