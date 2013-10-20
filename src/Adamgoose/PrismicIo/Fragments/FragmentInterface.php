<?php namespace Adamgoose\PrismicIo\Fragments;

interface FragmentInterface {

  /**
   * Parse the fragment to a string
   *
   * @return string
   */
  public function toString();

  /**
   * Parse the fragment to HTML
   *
   * @return string
   */
  public function toHtml();

  /**
   * Handle dynamic string typecasting
   *
   * @return string
   */
  public function __toString();

}