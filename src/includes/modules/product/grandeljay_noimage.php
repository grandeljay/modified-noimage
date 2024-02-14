<?php

/**
 * noimage
 *
 * @author  Jay Trees <noimage@grandels.email>
 * @link    https://github.com/grandeljay/modified-noimage
 *
 * @phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * @phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps
 */

use Grandeljay\Noimage\Constants;
use RobinTheHood\ModifiedStdModule\Classes\StdModule;

class grandeljay_noimage extends StdModule
{
    public const VERSION = '0.1.0';

    public function __construct()
    {
        parent::__construct(Constants::MODULE_NAME);

        $this->checkForUpdate(true);
    }

    protected function updateSteps(): int
    {
        if (version_compare($this->getVersion(), self::VERSION, '<')) {
            $this->setVersion(self::VERSION);

            return self::UPDATE_SUCCESS;
        }

        return self::UPDATE_NOTHING;
    }

    public function install(): void
    {
        parent::install();
    }

    public function remove(): void
    {
        parent::remove();
    }

    /**
     * Returns the URI of a product's image.
     *
     * @param string $return_name The last determined product image URI.
     * @param string $name        The filename of the product's image.
     * @param string $type        The image type (size). Possible values could
     *                            be: `mini`, `thumbnail`, `midi`, `info`,
     *                            `popup`.
     * @param string $path        The relative directory of the image type with a
     *                            trailing slash.
     *
     * @return string $return_name The new product image URI to use.
     */
    public function productImage(string $return_name, string $name, string $type, string $path): string
    {
        /**
         * Whether to show an image placeholder.
         *
         * @see includes/classes/product.php
         */
        $useStandardImage = defined('PRODUCT_IMAGE_SHOW_NO_IMAGE') && 'true' === PRODUCT_IMAGE_SHOW_NO_IMAGE;

        if (!$useStandardImage) {
            return $return_name;
        }

        /**
         * The image file to use as a placeholder, if it exists.
         *
         * @see includes/classes/product.php
         */
        $standard_image          = sprintf('grandeljay_noimage_%s.svg', $_SESSION['language_code']);
        $standard_image_path     = $path . $standard_image;
        $standard_image_path_alt = 'images/product_images/original_images/' . $standard_image;

        if (!file_exists($standard_image_path)) {
            /**
             * For SVG files, we don't need to create different versions since
             * they scale losslessly.
             */
            if (!file_exists($standard_image_path_alt)) {
                return $return_name;
            } else {
                $standard_image_path = $standard_image_path_alt;
            }
        }

        /**
         * Use the `standard_image` if there is no other image specified.
         */
        if (empty($name)) {
            return $standard_image_path;
        }

        return $return_name;
    }
}
