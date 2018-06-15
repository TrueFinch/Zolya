<?php
/**
 * Created by PhpStorm.
 * User: truefinch
 * Date: 09.06.18
 * Time: 0:51
 */

namespace App\Geometry;


class Rectangle implements ShapeInterface
{
    /**
     * @var Point boundaries of a segment
     */
    private $pa_, $pb_, $pc_, $pd_;

    /**
     * @var string $name_ name of class? idk
     */
    private $name_;

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
        $this->setName('Rectangle');
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

    /**
     * @return float
     */
    public function getPerimeter(): float
    {
        return $this->pa_->distance($this->pb_) + $this->pb_->distance($this->pc_)
            + $this->pc_->distance($this->pd_) + $this->pd_->distance($this->pa_);
    }

    /**
     * @param Point $point
     * @return bool
     */
    public function belong(Point $point): bool
    {
        $side_a = new Line($this->getPa(), $this->getPb());
        $side_b = new Line($this->getPb(), $this->getPc());
        $side_c = new Line($this->getPc(), $this->getPd());
        $side_d = new Line($this->getPd(), $this->getPa());
        return $side_a->belong($point) or $side_b->belong($point)
            or $side_c->belong($point) or $side_d->belong($point);
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return $this->pa_->distance($this->pb_) * $this->pb_->distance($this->pc_);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name_;
    }

    /**
     * @param string $name_
     */
    public function setName(string $name_): void
    {
        $this->name_ = $name_;
    }

    /**
     * @param Line $line
     * @return array
     */
    private function intersectLine(Line $line): array
    {
        return $line->intersect($this);
    }

    /**
     * @param Rectangle $rect
     * @return array
     */
    private function intersectRect(Rectangle $rect): array
    {
        /**
         * @var array Array of Points
         */
        $result = array();

        /**
         * Sides of rectangle rect
         * @var Line
         */
        $side_a1 = new Line($this->getPa(), $this->getPb());
        $side_b1 = new Line($this->getPb(), $this->getPc());
        $side_c1 = new Line($this->getPc(), $this->getPd());
        $side_d1 = new Line($this->getPd(), $this->getPa());

        $side_a2 = new Line($rect->getPa(), $rect->getPb());
        $side_b2 = new Line($rect->getPb(), $rect->getPc());
        $side_c2 = new Line($rect->getPc(), $rect->getPd());
        $side_d2 = new Line($rect->getPd(), $rect->getPa());

        $points = array();
        $points = array_merge($points, $side_a1->intersect($side_a2));
        $points = array_merge($points, $side_a1->intersect($side_b2));
        $points = array_merge($points, $side_a1->intersect($side_c2));
        $points = array_merge($points, $side_a1->intersect($side_d2));

        $points = array_merge($points, $side_b1->intersect($side_a2));
        $points = array_merge($points, $side_b1->intersect($side_b2));
        $points = array_merge($points, $side_b1->intersect($side_c2));
        $points = array_merge($points, $side_b1->intersect($side_d2));

        $points = array_merge($points, $side_c1->intersect($side_a2));
        $points = array_merge($points, $side_c1->intersect($side_b2));
        $points = array_merge($points, $side_c1->intersect($side_c2));
        $points = array_merge($points, $side_c1->intersect($side_d2));

        $points = array_merge($points, $side_d1->intersect($side_a2));
        $points = array_merge($points, $side_d1->intersect($side_b2));
        $points = array_merge($points, $side_d1->intersect($side_c2));
        $points = array_merge($points, $side_d1->intersect($side_d2));

        for ($i = 0; $i < count($points); ++$i) {
            if (array_search($points[$i], $result) == false) {
                array_push($result, $points[$i]);
            }
        }

        return $result;
    }

    /**
     * @param $shape
     * @return array
     */
    public function intersect($shape): array
    {
        /**
         * @var array of Points
         */
        $result = array();
        switch (gettype($shape)) {
            case "Line":
                $result = $this->intersectLine($shape);
                break;
            case "Rectangle":
                $result = $this->intersectRect($shape);
                break;
            case "Circle":
                break;
        }
        return $result;
    }

    //TODO: Realize class Rectangle
}