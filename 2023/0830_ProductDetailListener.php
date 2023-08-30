<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Customize\EventListener;

use Eccube\Event\EccubeEvents;
use Eccube\Event\EventArgs;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvents;


/**
 * 
 *
 * 
 */
class ProductDetailListener implements EventSubscriberInterface
{
    /**
     * Kernel Controller listener callback.
     */
    public function productInittialize(EventArgs $event)
    {
        $builder = $event->getArgument('builder');
        $Product = $event->getArgument('Product');

        if ($Product && $Product->getProductClasses()) {
            if (!is_null($Product->getClassName1())) {
                $builder->add('classcategory_id1', ChoiceType::class, [
                    'label' => $Product->getClassName1(),
                    'choices' => $Product->getClassCategories1AsFlip(),
                    'mapped' => false,
                    'expanded' => true,
                ]);
            }
            if (!is_null($Product->getClassName2())) {
                $builder->add('classcategory_id2', ChoiceType::class, [
                    'label' => $Product->getClassName2(),
                    'choices' => ['common.select' => '__unselected'],
                    'mapped' => false,
                    'expanded' => true,
                ]);
            }
        }

    }

    /**
     * Return the events to subscribe to.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            EccubeEvents::FRONT_PRODUCT_DETAIL_INITIALIZE => 'productInittialize',
        ];
    }
}
