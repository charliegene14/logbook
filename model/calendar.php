<?php 

class Month
{
    private $months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    public $month;
    public $year;

    public function __construct(?int $month = null, ?int $year = null)
    {

        if ($month === null || $month < 1 || $month > 12) {
            $month = intval(date('m'));
        }

        if ($year === null || $year < 1970 || $year > 2100) {
            $year = intval(date('Y'));
        }

        $this->month = $month;
        $this->year = $year;
    }

    public function getMonth(): string
    {

        return $this->months[$this->month - 1];
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getFirstDay(): DateTime
    {
        return new DateTime($this->year . '-' . $this->month . '-01');
    }

    public function getWeeks(): int
    {
        $start = $this->getFirstDay();
        $end = (clone $start)->modify('+1 month -1 day');
        $weeks = intval($end->format('W')) - intval($start->format('W'));

        if ($weeks < 0) {
            $weeks = intval($end->format('W'));
        }

        return $weeks + 1;
    }

    public function isInMonth(DateTime $daydate): bool
    {
        return $this->getFirstDay()->format('Y-m') === $daydate->format('Y-m');
    }

    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;

        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }

    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;

        if ($month > 12) {
            $month = 1;
            $year += 1;
        }

        return new Month($month, $year);
    }

    public function previousYear(): Month
    {
        $month = $this->month;
        $year = $this->year - 1;

        return new Month($month, $year);
    }

    public function nextYear(): Month
    {
        $month = $this->month;
        $year = $this->year + 1;

        return new Month($month, $year);
    }
}
