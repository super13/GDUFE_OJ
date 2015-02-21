package pro.jdbc.domain;

public class User {

	   public int getUser_id() {
		return user_id;
	}
	public void setUser_id(int user_id) {
		this.user_id = user_id;
	}
	public String getAccount() {
		return account;
	}
	public void setAccount(String account) {
		this.account = account;
	}
	public String getPassword() {
		return password;
	}
	public void setPassword(String password) {
		this.password = password;
	}
	public int getSolvedC() {
		return solvedC;
	}
	public void setSolvedC(int solvedC) {
		this.solvedC = solvedC;
	}
	public int getSubmitedC() {
		return submitedC;
	}
	public void setSubmitedC(int submitedC) {
		this.submitedC = submitedC;
	}
	public String getSolvedP() {
		return solvedP;
	}
	public void setSolvedP(String solvedP) {
		this.solvedP = solvedP;
	}
	public String getUnsolvedP() {
		return unsolvedP;
	}
	public void setUnsolvedP(String unsolvedP) {
		this.unsolvedP = unsolvedP;
	}
	public String getNick_name() {
		return nick_name;
	}
	public void setNick_name(String nick_name) {
		this.nick_name = nick_name;
	}
	public String getSchool() {
		return school;
	}
	public void setSchool(String school) {
		this.school = school;
	}
	public String getQq() {
		return qq;
	}
	public void setQq(String qq) {
		this.qq = qq;
	}
	private int user_id ;
    private String account;
    private String password;
    private int solvedC ;	
    private int submitedC ;
    private String solvedP;
    private String unsolvedP;
    private String nick_name;
    private String school;
    private String qq;
}
