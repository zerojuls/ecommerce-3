<?php

/*
 * This file is part of the Sonata product.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Component\Product;

use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\Component\Basket\BasketInterface;
use Sonata\Component\Basket\BasketElementInterface;
use Sonata\Component\Basket\BasketElementManagerInterface;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Component\Product\ProductInterface;
use Symfony\Component\Form\FormBuilder;

interface ProductProviderInterface
{
    /**
     * @param  \Sonata\Component\Basket\BasketElementManagerInterface $basketElementManager
     */
    public function setBasketElementManager(BasketElementManagerInterface $basketElementManager);

    /**
     * @return \Sonata\Component\Basket\BasketElementManagerInterface
     */
    public function getBasketElementManager();

    /**
     * @return string
     */
    public function getBaseControllerName();

    /**
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  \Symfony\Component\Form\FormBuilder        $formBuilder
     * @param  array                                      $options
     */
    public function defineAddBasketForm(ProductInterface $product, FormBuilder $formBuilder, array $options = array());

    /**
     * @param  \Sonata\Component\Basket\BasketElementInterface $basketElement
     * @param  \Symfony\Component\Form\FormBuilder             $formBuilder
     * @param  array                                           $options
     */
    public function defineBasketElementForm(BasketElementInterface $basketElement, FormBuilder $formBuilder, array $options = array());

    /**
     * return true if the basket element is still valid
     *
     * @param  \Sonata\Component\Basket\BasketInterface        $basket
     * @param  ProductInterface                                $product
     * @param  \Sonata\Component\Basket\BasketElementInterface $newBasketElement
     */
    public function basketAddProduct(BasketInterface $basket, ProductInterface $product, BasketElementInterface $newBasketElement);

    /**
     * Merge a product with another when the product is already present into the basket
     *
     * @param  \Sonata\Component\Basket\BasketInterface        $basket
     * @param  ProductInterface                                $product
     * @param  \Sonata\Component\Basket\BasketElementInterface $newBasketElement
     */
    public function basketMergeProduct(BasketInterface $basket, ProductInterface $product, BasketElementInterface $newBasketElement);

    /**
     * @param \Sonata\Component\Basket\BasketElementInterface $basketElement
     *
     * @return boolean true if the basket element is still valid
     */
    public function isValidBasketElement(BasketElementInterface $basketElement);

    /**
     * This method return the return price of basket element, this method
     * allow to update the price of the basket element depend on the presence
     * of another product
     *
     * @param  \Sonata\Component\Basket\BasketInterface        $basket
     * @param  \Sonata\Component\Basket\BasketElementInterface $basketElement
     *
     * @return float the unit price of the basketElement
     */
    public function basketCalculatePrice(BasketInterface $basket, BasketElementInterface $basketElement);

    /**
     * Return true if the product can be added to the provided basket
     *
     * @param  \Sonata\Component\Basket\BasketInterface   $basket
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  array                                      $options
     *
     * @return boolean
     */
    public function isAddableToBasket(BasketInterface $basket, ProductInterface $product, array $options = array());

    /**
     * @param  null|ProductInterface $product
     * @param  array                 $options
     *
     * @return BasketElementInterface
     */
    public function createBasketElement(ProductInterface $product = null, array $options = array());

    /**
     * @param  \Sonata\AdminBundle\Show\ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper);

    /**
     * @param  \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    public function buildEditForm(FormMapper $formMapper);

    /**
     * @param  \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    public function buildCreateForm(FormMapper $formMapper);

    /**
     * @param  \Sonata\Component\Basket\BasketElementInterface $basketElement
     * @param  null|\Sonata\Component\Product\ProductInterface $product
     * @param  array                                           $options
     * @return void
     */
    public function buildBasketElement(BasketElementInterface $basketElement, ProductInterface $product = null, array $options = array());

    /**
     * return an array of errors if any, you can also manipulate the basketElement if require
     * please not you always work with a clone version of the basketElement.
     *
     * If the basket is valid it will then replace the one in session
     *
     * @param  \Sonata\AdminBundle\Validator\ErrorElement      $errorElement
     * @param  \Sonata\Component\Basket\BasketElementInterface $basketElement
     * @param  \Sonata\Component\Basket\BasketInterface        $basket
     * @return void
     */
    public function validateFormBasketElement(ErrorElement $errorElement, BasketElementInterface $basketElement, BasketInterface $basket);

    /**
     * Creates a variation from a given Product.
     *
     * @param \Sonata\Component\Product\ProductInterface $product
     *
     * @throws \RuntimeException
     *
     * @return \Sonata\Component\Product\ProductInterface
     */
    public function createVariation(ProductInterface $product);

    /**
     * Copy chosen data from a Product to its variations.
     *
     * @param \Sonata\Component\Product\ProductInterface $product   A parent Product instance
     * @param string                                     $name      What data to copy? Accepted values are : 'all', 'product_deliveries', 'product_categories', 'product_pictures'
     * @param bool                                       $forceCopy
     */
    public function copyVariation(ProductInterface $product, $name = 'all', $forceCopy = false);

    /**
     * Copy base Product data to variations.
     *
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  bool                                       $forceCopy
     */
    public function copyProductVariation(ProductInterface $product, $forceCopy = false);

    /**
     * Copy base Product deliveries to variations.
     *
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  bool                                       $forceCopy
     */
    public function copyProductDeliveriesVariation(ProductInterface $product, $forceCopy = false);

    /**
     * Copy base Product categories to variations.
     *
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  bool                                       $forceCopy
     */
    public function copyProductCategoriesVariation(ProductInterface $product, $forceCopy = false);

    /**
     * Copy base Product images to variations.
     *
     * @param  \Sonata\Component\Product\ProductInterface $product
     * @param  bool                                       $forceCopy
     */
    public function copyProductImagesVariation(ProductInterface $product, $forceCopy = false);
}
