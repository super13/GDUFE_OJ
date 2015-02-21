package pro.jdbc.domain;

import java.util.Date;

public class Statu {

	public int getStatu_id() {
		return statu_id;
	}
	public void setStatu_id(int statu_id) {
		this.statu_id = statu_id;
	}
	public int getProblem_id() {
		return problem_id;
	}
	public void setProblem_id(int problem_id) {
		this.problem_id = problem_id;
	}
	
	public String getUser() {
		return user;
	}
	public void setUser(String user) {
		this.user = user;
	}
	public String getResult() {
		return result;
	}
	public void setResult(String result) {
		this.result = result;
	}
	public String getLang() {
		return lang;
	}
	public void setLang(String lang) {
		this.lang = lang;
	}
	public int getCodeL() {
		return codeL;
	}
	public void setCodeL(int codeL) {
		this.codeL = codeL;
	}
	public Date getTime() {
		return time;
	}
	public void setTime(Date time) {
		this.time = time;
	}
	public String getNick_name() {
		return nick_name;
	}
	public void setNick_name(String nick_name) {
		this.nick_name = nick_name;
	}
	public long getUse_time() {
		return use_time;
	}
	public void setUse_time(long use_time) {
		this.use_time = use_time;
	}
	private int statu_id;
	private int problem_id;
	private String user;
	private String nick_name;
	private String result;
	private String lang;
	private long use_time =0;
	private int codeL;
	private Date time;
}
