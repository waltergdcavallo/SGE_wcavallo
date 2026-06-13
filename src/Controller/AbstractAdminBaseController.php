<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractAdminBaseController extends AbstractController
{
    protected function addInfoMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'info',
            $message
        );
    }
    //
    protected function addWarnMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'warning',
            $message
        );
    }
    //
    protected function addErrorMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'danger',
            $message
        );
    }
    //
    protected function addSuccessMessage(
        string $message
    ): void
    {
        $this->addFlash(
            'success',
            $message
        );
    }
}
?>