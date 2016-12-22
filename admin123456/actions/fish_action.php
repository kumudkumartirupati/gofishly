<?php
	require_once("../../includes/initialize.php");
	if(!$admin_session->is_logged_in()) {
		redirect_to("../login.php");
	}
	if(isset($_POST['addFish'])) {
		$return_url = "../index.php?tab=3";
		$fish = new Fish();
		$fish->type = trim($_POST['type']);
		$fish->breed = trim($_POST['breed']);		
		$img_ful = $_FILES['img_ful'];
		$img_tmb = $_FILES['img_tmb'];
		$fish->hasPrm = (int)trim($_POST['hasPrm']);
		if (empty($fish->type) || empty($fish->breed) || ($fish->hasPrm != 0 && $fish->hasPrm != 1 && $fish->hasPrm != 2)) {
			redirect_to($return_url."&frm_epty_err=1");
		}
		if(isset($img_ful['name']) && !empty($img_ful['name'])) {
			if (!$fish->attach_img_ful($img_ful)) {
				$fish->unset_temp_files();
				redirect_to($return_url."&img_type_err=1");
			}
			if (!$fish->save_img_ful()) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				redirect_to($return_url."&img_err=1");
			}
		} else {
			redirect_to($return_url."&img_err=1");
		}
		if(isset($img_tmb['name']) && !empty($img_tmb['name'])) {
			if (!$fish->attach_img_tmb($img_tmb)) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				redirect_to($return_url."&img_type_err=1");
			}
			if (!$fish->save_img_tmb()) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				$fish->destroy_img_tmb();
				redirect_to($return_url."&img_err=1");
			}
		} else {
			$fish->unset_temp_files();
			$fish->destroy_img_ful();
			redirect_to($return_url."&img_err=1");
		}
		if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {
			$rch_style = trim($_POST['rch_style']);
			$rcl_style = trim($_POST['rcl_style']);
			$rpk_option = trim($_POST['rpk_option']);
			$r_price = (float)trim($_POST['r_price']);
			if (empty($rch_style) || empty($rcl_style) || empty($r_price)) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				$fish->destroy_img_tmb();
				redirect_to($return_url."&frm_epty_err=1");
			}
			if (!empty($rpk_option)) {
				$nrpk_option = new PackOption();			
				$nrpk_option->opt_name = $rpk_option;
				$nrpk_option->isPrm = 0;
			}
			$nrcl_style = new CleanStyle();			
			$nrcl_style->style = $rcl_style;
			$nrcl_style->isPrm = 0;
			$nrch_style = new ChopStyle();			
			$nrch_style->style = $rch_style;
			$nrch_style->isPrm = 0;
			$nr_price = new PriceOption();			
			$nr_price->price = $r_price;
			$nr_price->isPrm = 0;
			$nr_price->opt_name = "Price Per Half Kg Pack";
		}
		if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {
			$pch_style = trim($_POST['pch_style']);
			$pcl_style = trim($_POST['pcl_style']);
			$ppk_option = trim($_POST['ppk_option']);
			$p_price = (float)trim($_POST['p_price']);
			if (empty($pch_style) || empty($pcl_style) || empty($p_price)) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				$fish->destroy_img_tmb();
				redirect_to($return_url."&frm_epty_err=1");
			}
			if (!empty($ppk_option)) {
				$nppk_option = new PackOption();			
				$nppk_option->opt_name = $ppk_option;
				$nppk_option->isPrm = 1;
			}
			$npcl_style = new CleanStyle();			
			$npcl_style->style = $pcl_style;
			$npcl_style->isPrm = 1;
			$npch_style = new ChopStyle();			
			$npch_style->style = $pch_style;
			$npch_style->isPrm = 1;
			$np_price = new PriceOption();			
			$np_price->price = $p_price;
			$np_price->isPrm = 1;
			$np_price->opt_name = "Price Per Half Kg Pack";
		}
		if($fish->add_fish()) {
			if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {
				$nrcl_style->fsh_id = $fish->id;
				$nrch_style->fsh_id = $fish->id;
				$nr_price->fsh_id = $fish->id;
				if (isset ($nppk_option)) {
					$nppk_option->fsh_id = $fish->id;
					$nppk_option->create();
				}
				if (isset ($nrpk_option)) {
					$nrpk_option->fsh_id = $fish->id;
					$nrpk_option->create();
				}
				$nrcl_style->create();
				$nrch_style->create();
				$nr_price->create();
			}
			if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {
				$npcl_style->fsh_id = $fish->id;
				$npch_style->fsh_id = $fish->id;			
				$np_price->fsh_id = $fish->id;
				$npcl_style->create();
				$npch_style->create();
				$np_price->create();
			}
			redirect_to($return_url."&fsh_id=".$fish->id."&fsh_add=1");
		}
	} elseif(isset($_POST['updateFish'])) {
		$fish = Fish::find_by_id(trim($_POST['fsh_id']));
		$return_url = "../index.php?tab=3&fsh_id=".$fish->id;
		if (!empty(trim($_POST['type']))) {
			$fish->type = trim($_POST['type']);
		}
		if (!empty(trim($_POST['breed']))) {
			$fish->breed = trim($_POST['breed']);
		}
		if (trim($_POST['hasPrmEdit']) == 0 || trim($_POST['hasPrmEdit']) == 1 || trim($_POST['hasPrmEdit']) == 2) {
			$fish->hasPrm = trim($_POST['hasPrmEdit']);
		}
		$img_ful = $_FILES['img_ful'];
		$img_tmb = $_FILES['img_tmb'];
		if(isset($img_ful['name']) && !empty($img_ful['name'])) {
			$fish->destroy_img_ful();
			if (!$fish->attach_img_ful($img_ful)) {
				$fish->unset_temp_files();
				redirect_to($return_url."&img_type_err=1");
			}
			if (!$fish->save_img_ful()) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				redirect_to($return_url."&img_err=1");
			}
		}
		if(isset($img_tmb['name']) && !empty($img_tmb['name'])) {
			$fish->destroy_img_tmb();
			if (!$fish->attach_img_tmb($img_tmb)) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				redirect_to($return_url."&img_type_err=1");
			}
			if (!$fish->save_img_tmb()) {
				$fish->unset_temp_files();
				$fish->destroy_img_ful();
				$fish->destroy_img_tmb();
				redirect_to($return_url."&img_err=1");
			}
		}
		if($fish->update_fish()) {
			redirect_to($return_url."&fsh_add=1");
		} else {
			redirect_to($return_url."&err=1");
		}
	} elseif (isset($_GET['tab']) && isset($_GET['fsh_id']) && isset($_GET['delFish'])) {
		$id = $db->escape_value(trim($_GET['fsh_id']));
		$fish = Fish::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"];
		delOptions($fish->id, "CleanStyle");
		delOptions($fish->id, "ChopStyle");
		delOptions($fish->id, "PriceOption");
		delOptions($fish->id, "PackOption");
		if ($fish->delete_fish()) {
			redirect_to($return_url.'&del_fsh_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['ch_id'])) {
		$id = $db->escape_value(trim($_GET['ch_id']));
		$ch_style = ChopStyle::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"]."&fsh_id=".$ch_style->fsh_id;
		if ($ch_style->delete()) {
			redirect_to($return_url.'&del_ch_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['cl_id'])) {
		$id = $db->escape_value(trim($_GET['cl_id']));
		$cl_style = CleanStyle::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"]."&fsh_id=".$cl_style->fsh_id;
		if ($cl_style->delete()) {
			redirect_to($return_url.'&del_cl_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['pr_id'])) {
		$id = $db->escape_value(trim($_GET['pr_id']));
		$pr_option = PriceOption::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"]."&fsh_id=".$pr_option->fsh_id;
		if ($pr_option->delete()) {
			redirect_to($return_url.'&del_pr_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['pk_id'])) {
		$id = $db->escape_value(trim($_GET['pk_id']));
		$pk_option = PackOption::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"]."&fsh_id=".$pk_option->fsh_id;
		if ($pk_option->delete()) {
			redirect_to($return_url.'&del_pk_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_POST['editClStyle'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$cl_id = trim($_POST['cl_id']);
		$cl_style = trim($_POST['cl_style']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($cl_style)) {
			$cl = CleanStyle::find_by_id($cl_id);
			$cl->style = $cl_style;
			$cl->update();
			redirect_to($return_url."&edit_cl_suc=1");
		} else {
			redirect_to($return_url."&edit_cl_err=1");
		}
	} elseif (isset($_POST['editChStyle'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$ch_id = trim($_POST['ch_id']);
		$ch_style = trim($_POST['ch_style']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($ch_style)) {
			$ch = ChopStyle::find_by_id($ch_id);
			$ch->style = $ch_style;
			$ch->update();
			redirect_to($return_url."&edit_ch_suc=1");
		} else {
			redirect_to($return_url."&edit_ch_err=1");
		}
	} elseif (isset($_POST['editPrOption'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$pr_id = trim($_POST['pr_id']);
		$pr_option = trim($_POST['pr_option']);
		$price = (float)trim($_POST['price']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($pr_option) || !empty($price)) {
			$pr = PriceOption::find_by_id($pr_id);
			$pr->opt_name = $pr_option;
			$pr->price = $price;
			$pr->update();
			redirect_to($return_url."&edit_pr_suc=1");
		} else {
			redirect_to($return_url."&edit_pr_err=1");
		}
	} elseif (isset($_POST['editPkOption'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$pk_id = trim($_POST['pk_id']);
		$pk_option = trim($_POST['pk_option']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($pk_option)) {
			$pk = PackOption::find_by_id($pk_id);
			$pk->opt_name = $pk_option;
			$pk->update();
			redirect_to($return_url."&edit_pk_suc=1");
		} else {
			redirect_to($return_url."&edit_pk_err=1");
		}
	} elseif (isset($_POST['addClStyle'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$cl_style = trim($_POST['cl_style']);
		$isPrm = (int)trim($_POST['isPrm']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($cl_style) && ($isPrm == 0 || $isPrm == 1)) {
			$cl = new CleanStyle();
			$cl->id = 0;
			$cl->style = $cl_style;
			$cl->fsh_id = $fsh_id;
			$cl->isPrm = $isPrm;
			$cl->create();
			redirect_to($return_url."&add_cl_suc=1");
		} else {
			redirect_to($return_url."&add_err=1");
		}
	} elseif (isset($_POST['addChStyle'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$ch_style = trim($_POST['ch_style']);
		$isPrm = (int)trim($_POST['isPrm']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($ch_style) && ($isPrm == 0 || $isPrm == 1)) {
			$ch = new ChopStyle();
			$ch->id = 0;
			$ch->style = $ch_style;
			$ch->fsh_id = $fsh_id;
			$ch->isPrm = $isPrm;
			$ch->create();
			redirect_to($return_url."&add_ch_suc=1");
		} else {
			redirect_to($return_url."&add_err=1");
		}
	} elseif (isset($_POST['addPrOption'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$pr_option = trim($_POST['pr_option']);
		$price = (float)trim($_POST['price']);
		$isPrm = (int)trim($_POST['isPrm']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($pr_option) && !empty($price) && ($isPrm == 0 || $isPrm == 1)) {
			$pr = new PriceOption();
			$pr->opt_name = $pr_option;
			$pr->price = $price;
			$pr->fsh_id = $fsh_id;
			$pr->isPrm = $isPrm;
			$pr->create();
			redirect_to($return_url."&add_pr_suc=1");
		} else {
			redirect_to($return_url."&add_err=1");
		}
	} elseif (isset($_POST['addPkOption'])) {
		$tab = trim($_POST['tab']);
		$fsh_id = trim($_POST['fsh_id']);
		$pk_option = trim($_POST['pk_option']);
		$isPrm = (int)trim($_POST['isPrm']);
		$return_url = "../index.php?tab=".$tab."&fsh_id=".$fsh_id;
		if (!empty($pk_option) && ($isPrm == 0 || $isPrm == 1)) {
			$pk = new PackOption();
			$pk->id = 0;
			$pk->opt_name = $pk_option;
			$pk->fsh_id = $fsh_id;
			$pk->isPrm = $isPrm;
			$pk->create();
			redirect_to($return_url."&add_pk_suc=1");
		} else {
			redirect_to($return_url."&add_err=1");
		}
	} else {
		$id="";
		$fish="";
		$return_url = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>