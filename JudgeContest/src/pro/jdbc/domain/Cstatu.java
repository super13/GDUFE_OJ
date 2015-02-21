package pro.jdbc.domain;

import java.util.Date;

public class Cstatu {


	public int getCstatu_id() {
		return cstatu_id;
	}
	public void setCstatu_id(int cstatu_id) {
		this.cstatu_id = cstatu_id;
	}
	public int getProblem_id() {
		return problem_id;
	}
	public void setProblem_id(int problem_id) {
		this.problem_id = problem_id;
	}
	public int getCid() {
		return cid;
	}
	public void setCid(int cid) {
		this.cid = cid;
	}
	public String getUser() {
		return user;
	}
	public void setUser(String user) {
		this.user = user;
	}
	public String getNick_name() {
		return nick_name;
	}
	public void setNick_name(String nick_name) {
		this.nick_name = nick_name;
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
	public long getUse_time() {
		return use_time;
	}
	public void setUse_time(long use_time) {
		this.use_time = use_time;
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
	private int cstatu_id;
	private int problem_id;
	private int cid;
	private String user;
	private String nick_name;
	private String result;
	private String lang;
	private long use_time =0;
	private int codeL;
	private Date time;
}
