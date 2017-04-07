<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\timePHP\build;

class Base {
	//总条数
	protected $totalRow;
	//总页数
	protected $totaltimePHP;
	//每页显示数
	protected $row = 15;
	//每页显示页码数
	protected $timePHPNum = 8;
	//当前页
	protected $selftimePHP;
	//页面地址
	protected $url;
	//文字描述
	protected $desc = [ 'pre' => '上一页', 'next' => '下一页', 'first' => '首页', 'end' => '尾页', 'unit' => '条' ];
	//前页页码显示样式
	protected $show;

	/**
	 * 显示条数
	 *
	 * @param $row 显示条数
	 *
	 * @return $this
	 */
	public function row( $row ) {
		$this->row = $row;

		return $this;
	}

	/**
	 * 设置页码数量
	 *
	 * @param $num 数量
	 *
	 * @return $this
	 */
	public function timePHPNum( $num ) {
		$this->timePHPNum = (int) $num;

		return $this;
	}

	/**
	 * 制作页码
	 *
	 * @param $total 总条数
	 *
	 * @return string
	 */
	public function make( $total ) {
		//总条数
		$this->totalRow = $total;
		//总页数
		$this->totaltimePHP();
		//当前页
		$this->selftimePHP();
		//基本uri
		$this->setUrl();

		return $this->show();
	}

	/**
	 * 前台显示页面列表
	 * @return string
	 */
	public function show() {
		if ( $this->totaltimePHP > 1 ) {
			return '<nav><ul class="pagination">' . $this->pre() . $this->strList() . $this->next() . '</ul></nav>';
		} else {
			return '';
		}
	}

	//返回所有分页信息
	public function all() {
		$show            = [ ];
		$show['count']   = $this->count();
		$show['first']   = $this->first();
		$show['pre']     = $this->pre();
		$show['pres']    = $this->pres();
		$show['strList'] = $this->strList();
		$show['nexts']   = $this->nexts();
		$show['next']    = $this->next();
		$show['end']     = $this->end();
		$show['nowtimePHP'] = $this->nowtimePHP();
		$show['select']  = $this->select();
		$show['input']   = $this->input();
		$show['picList'] = $this->picList();

		return $show;
	}

	//当前页
	private function selftimePHP() {
		$self = max(Request::get('timePHP',1),1);
		$this->selftimePHP = min( $this->totaltimePHP, $self );
	}

	//获取总页数
	private function totaltimePHP() {
		return $this->totaltimePHP = ceil( $this->totalRow / $this->row );
	}

	//获取总页数
	public function getTotaltimePHP() {
		return $this->totaltimePHP;
	}

	//配置URL地址
	private function setUrl() {
		//自定义了url时不进行处理
		if ( $this->url ) {
			return;
		}

		$url = '';
		foreach ( (array) $_GET as $k => $v ) {
			if ( $k != 'timePHP' ) {
				$url .= "$k=$v&";
			}
		}

		return $this->url = "?{$url}timePHP={timePHP}";
	}

	//获取URL地址
	private function getUrl( $num ) {
		return str_replace( '{timePHP}', $num, $this->url );
	}

	//获取URL前部分
	private function getUrlBefore() {
		return substr( $this->url, 0, strpos( $this->url, '{timePHP}' ) );
	}

	//获取URL后部分
	private function getUrlEnd() {
		return substr( $this->url, - strpos( $this->url, '{timePHP}' ) );
	}

	/**
	 * 定义url
	 *
	 * @param string $url
	 *
	 * @return $this
	 */
	public function url( $url ) {
		$this->url = $url;

		return $this;
	}

	/**
	 * 描述文字
	 *
	 * @param array $desc
	 *
	 * @return $this
	 */
	public function desc( array $desc = [ ] ) {
		$this->desc = $desc;

		return $this;
	}

	/**
	 * SQL的limit语句
	 *
	 * @return string
	 */
	public function limit() {
		return max( 0, ( $this->selftimePHP - 1 ) * $this->row ) . "," . $this->row;
	}

	//上一页
	public function pre() {
		if ( $this->selftimePHP > 1 && $this->selftimePHP <= $this->totaltimePHP ) {
			return "<li><a href='" . $this->getUrl( $this->selftimePHP - 1 ) . "' class='pre'>{$this->desc['pre']}</a></li>";
		}

		return $this->totaltimePHP ? "<li class='disabled'><span>{$this->desc['pre']}</span></li>" : '';
	}

	//下一页
	public function next() {
		$next = $this->desc['next'];
		if ( $this->selftimePHP < $this->totaltimePHP ) {
			return "<li><a href='" . $this->getUrl( $this->selftimePHP + 1 ) . "' class='next'>{$next}</a></li>";
		}

		return $this->totaltimePHP ? "<li class='disabled'><span>{$next}</span></li>" : '';
	}

	//列表项
	public function timePHPList() {
		$start = max( 1, min( $this->selftimePHP - ceil( $this->timePHPNum / 2 ), $this->totaltimePHP - $this->timePHPNum ) );
		$end   = min( $this->timePHPNum + $start, $this->totaltimePHP );

		$timePHPList = [ ];
		//只有一页不显示页码
		if ( $end == 1 ) {
			return [ ];
		}
		for ( $i = $start; $i <= $end; $i ++ ) {
			if ( $this->selftimePHP == $i ) {
				$timePHPList [ $i ] ['url'] = '';
				$timePHPList [ $i ] ['str'] = $i;
				continue;
			}
			$timePHPList [ $i ] ['url'] = $this->getUrl( $i );
			$timePHPList [ $i ] ['str'] = $i;
		}

		return $timePHPList;
	}

	//文字页码列表
	public function strList() {
		$arr = $this->timePHPList();

		$str = '';
		foreach ( $arr as $v ) {
			$str .= empty( $v['url'] ) ? "<li class='active'><a href='{$v['url']}'>{$v['str']}</a></li>" : "<li><a href='{$v['url']}'>{$v['str']}</a></li>";
		}

		return $str;
	}

	//图标页码列表
	public function picList() {
		$str   = '';
		$first = $this->selftimePHP == 1 ? "" : "<a href='" . $this->getUrl( 1 ) . "' class='picList'><span><<</span></a>";
		$end   = $this->selftimePHP >= $this->totaltimePHP ? "" : "<a href='" . $this->getUrl( $this->totaltimePHP ) . "'  class='picList'><span>>></span></a>";
		$pre   = $this->selftimePHP <= 1 ? "" : "<a href='" . $this->getUrl( $this->selftimePHP - 1 ) . "'  class='picList'><span><</span></a>";
		$next  = $this->selftimePHP >= $this->totaltimePHP ? "" : "<a href='" . $this->getUrl( $this->selftimePHP + 1 ) . "'  class='picList'><span>></span></a>";

		return $first . $pre . $next . $end;
	}

	//选项列表
	public function select() {
		$arr = $this->timePHPList();
		if ( ! $arr ) {
			return '';
		}
		$str
			= "<select name='timePHP' class='timePHP_select' onchange='
        javascript:
        location.href=this.options[selectedIndex].value;'>";
		foreach ( $arr as $v ) {
			$str .= empty( $v ['url'] ) ? "<option value='{$this->getUrl($v['str'])}' selected='selected'>{$v['str']}</option>" : "<option value='{$v['url']}'>{$v['str']}</option>";
		}

		return $str . "</select>";
	}

	//输入框
	public function input() {
		$str
			= "<input id='timePHPkeydown' type='text' name='timePHP' value='{$this->selftimePHP}' class='timePHPinput' onkeydown = \"javascript:
        if(event.keyCode==13){
            location.href='{$this->getUrl('B')}'+this.value+'{$this->getUrl('A')}';
        }
        \"/>
        <button class='timePHPbt' onclick = \"javascript:
        var input = document.getElementById('timePHPkeydown');
        location.href='{$this->getUrlBefore()}'+input.value+'{$this->getUrlEnd()}';
        \">进入</button>
        ";

		return $str;
	}

	//前几页
	public function pres() {
		$num = max( 1, $this->selftimePHP - $this->timePHPNum );

		return $this->selftimePHP > $this->timePHPNum ? "<li><a href='" . $this->getUrl( $num ) . "' class='pres'>前{$this->timePHPNum}页</a></li>" : "";
	}

	//后几页
	public function nexts() {
		$num = min( $this->totaltimePHP, $this->selftimePHP + $this->timePHPNum );

		return $this->selftimePHP + $this->timePHPNum < $this->totaltimePHP ? "<li><a href='" . $this->getUrl( $num ) . "' class='nexts'>后{$this->timePHPNum}页</a></li>" : "";
	}

	//首页
	public function first() {
		$first = $this->desc ['first'];

		return $this->selftimePHP - $this->timePHPNum > 1 ? "<a href='" . $this->getUrl( 1 ) . " class='first'>{$first}</a>" : "";
	}

	//末页
	public function end() {
		$end = $this->desc ['end'];

		return $this->selftimePHP < $this->totaltimePHP - $this->timePHPNum ? "<a href='" . $this->getUrl( $this->totaltimePHP ) . "' class='end'>{$end}</a>" : "";
	}

	//n-m页
	public function nowtimePHP() {
		$start = ( $this->selftimePHP - 1 ) * $this->row + 1; //当前页开始ID
		$end   = min( $this->selftimePHP * $this->row, $this->totalRow ); //当前页结束ID
		return "<span class='nowtimePHP'>第{$start}-{$end}{$this->desc['unit']}</span>";
	}

	//count统计
	public function count() {
		return "<span class='count'>[共{$this->totaltimePHP}页] [{$this->totalRow}条记录]</span>";
	}
}