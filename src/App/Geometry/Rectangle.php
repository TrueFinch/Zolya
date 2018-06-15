<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 09.06.18
 * Time: 0:51
 */

namespace App\Geometry;


class Rectangle
{
    /**
     * @var Point boundaries of a segment
     */
    private $pa_, $pb_, $pc_, $pd_;

    /**
     * Rectangle constructor.
     * @param Point $pa_
     * @param Point $pb_
     * @param Point $pc_
     * @param Point $pd_
     */
    public function __construct(Point $pa_, Point $pb_, Point $pc_, Point $pd_)
    {
        $this->pa_ = $pa_;
        $this->pb_ = $pb_;
        $this->pc_ = $pc_;
        $this->pd_ = $pd_;
    }

    /**
     * @return Point
     */
    public function getPa(): Point
    {
        return $this->pa_;
    }

    /**
     * @param Point $pa_
     */
    public function setPa(Point $pa_): void
    {
        $this->pa_ = $pa_;
    }

    /**
     * @return Point
     */
    public function getPb(): Point
    {
        return $this->pb_;
    }

    /**
     * @param Point $pb_
     */
    public function setPb(Point $pb_): void
    {
        $this->pb_ = $pb_;
    }

    /**
     * @return Point
     */
    public function getPc(): Point
    {
        return $this->pc_;
    }

    /**
     * @param Point $pc_
     */
    public function setPc(Point $pc_): void
    {
        $this->pc_ = $pc_;
    }

    /**
     * @return Point
     */
    public function getPd(): Point
    {
        return $this->pd_;
    }

    /**
     * @param Point $pd_
     */
    public function setPd(Point $pd_): void
    {
        $this->pd_ = $pd_;
    }



    //TODO: Realize class Rectangle
}