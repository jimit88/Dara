<?php
 
namespace Plumtree\Weeeee\Helper;
 
class Data extends \Magento\Weee\Helper\Data
{    
   
    public function getRowWeeeTaxInclTax($item)
    {
        $weeeTaxAppliedAmounts = $this->getApplied($item);
        $totalWeeeTaxIncTaxApplied = 0;
		if($weeeTaxAppliedAmounts != ''){ 
        foreach ($weeeTaxAppliedAmounts as $weeeTaxAppliedAmount) {
            $totalWeeeTaxIncTaxApplied += max($weeeTaxAppliedAmount['row_amount_incl_tax'], 0);
        }
		}
        return $totalWeeeTaxIncTaxApplied;
    }

    public function getBaseRowWeeeTaxInclTax($item)
    {
        $weeeTaxAppliedAmounts = $this->getApplied($item);
        $totalWeeeTaxIncTaxApplied = 0;
		if($weeeTaxAppliedAmounts != ''){ 
        foreach ($weeeTaxAppliedAmounts as $weeeTaxAppliedAmount) {
            $totalWeeeTaxIncTaxApplied += max($weeeTaxAppliedAmount['base_row_amount_incl_tax'], 0);
        }
		}
        return $totalWeeeTaxIncTaxApplied;
    }
	
}
?>