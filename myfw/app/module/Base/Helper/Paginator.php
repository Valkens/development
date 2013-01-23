<?php
class Base_Helper_Paginator
{
    public $items_per_page;
    public $items_total;
    public $current_page = 1;
    public $num_pages;
    public $mid_range = 6;
    public $return;
    public $baseUrl;
    public $prefix = 'page/';
    public $first = 'First';
    public $last = 'Last';
    public $end = 'End';
    public $prev = '«';
    public $next = '»';

    function paginate()
    {
        $this->num_pages = ceil($this->items_total/$this->items_per_page);

        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;

        $prev_page = $this->current_page - 1;
        $next_page = $this->current_page + 1;

        $href = "{$this->baseUrl}/{$this->prefix}";

        if ($this->num_pages > $this->mid_range) {
            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);

            if ($this->start_range <= 0) {
                $this->end_range += abs($this->start_range) + 1;
                $this->start_range = 1;
            }

            if ($this->end_range > $this->num_pages) {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }

            $this->range = range($this->start_range, $this->end_range);

            for ($i = $this->start_range; $i < $this->end_range; $i++) {
                if ($this->range[0] >= 2 And $i == $this->range[0]) {
                    $this->return .= "<a class=\"paginate\" href=\"{$this->baseUrl}\">{$this->first}</a>";
                    $this->return .= ($this->current_page != 1 And $this->items_total >= $this->mid_range)
                                  ? "<a class=\"paginate\" href=\"{$href}{$prev_page}\">{$this->prev}</a> "
                                  : '';
                    $this->return .= ' ... ';
                }

                if ($i == 1) {
                    $url = $this->baseUrl;
                } else {
                    $url = $href . $i;
                }

                // loop through all pages. if first, last, or in range, display
                if ($i==1 Or $i==$this->num_pages Or in_array($i,$this->range)) {
                    $this->return .= ($i == $this->current_page And $this->current_page != $this->num_pages)
                                   ? "<a class=\"current\" href=\"javascript:void(0)\">$i</a>"
                                   : "<a class=\"paginate\" href=\"{$url}\">$i</a>";
                }

                if ($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) {
                    $this->return .= " ... ";
                }
            }

            if ($next_page != $i) {
                $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= $this->mid_range) And ($this->current_page != $this->num_pages))
                               ? "<a class=\"paginate\" href=\"{$href}{$next_page}\">{$this->next}</a>"
                               : '';
                $this->return .= ($this->current_page == $this->num_pages)
                               ? "<a class=\"current\" href=\"javascript:void(0)\">{$this->num_pages}</a>"
                               : "<a class=\"paginate\" href=\"{$href}{$this->num_pages}\">{$this->end}</a>";
            } else {
                $this->return .= "<a class=\"paginate\" href=\"{$href}{$next_page}\">{$next_page}</a>";
            }
        } else {
            for($i = 1; $i <= $this->num_pages; $i++) {
                if ($i == 1) {
                    $url = $this->baseUrl;
                } else {
                    $url = $href . $i;
                }

                $p = $i;
                if ($i == $this->num_pages) {
                    $p = $this->end;
                }

                $this->return .= ($i == $this->current_page)
                               ? "<a class=\"current\" href=\"javascript:void(0)\">$i</a>"
                               : "<a class=\"paginate\" href=\"{$url}\">$p</a>";
            }
        }
    }

    function display_pages()
    {
        return $this->return;
    }

}