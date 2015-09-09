<?php

namespace Disko\CoreBundle\Services;

/**
 * ContextService
 */
class ContextService extends BaseService
{
    /**
     * @var string
     */
    protected $device;

    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    public function device()
    {
        if (is_null($this->device)) {
            $device = (isset($_SERVER['HTTP_X_UA_DEVICE'])?$_SERVER['HTTP_X_UA_DEVICE']:'');

            // cf : https://github.com/varnish/varnish-devicedetect/blob/master/devicedetect.vcl
            switch (strtolower($device)) {
                case 'tablet-ipad':
                case 'tablet-android':
                    return 'mobile';
                    break;

                case 'mobile-iphone':
                case 'mobile-android':
                case 'mobile-firefoxos':
                case 'mobile-smartphone':
                case 'mobile-generic':
                    return 'mobile';
                    break;

                default:
                case 'pc':
                    return 'desktop';
                    break;
            }
        }

        return $this->device;
    }

    public function connected()
    {
        return $this->securityContext->getToken()
        && $this->securityContext->isGranted('ROLE_USER');
    }
}
