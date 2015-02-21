package pro.jdbc.domain;

public class Problem {
	private int problem_id;
	private String title;
	private String content;
	private int calTimeout;
	private int  runTimeout;

	private String input;
	private String output;
	private String spInput;
	private String spOutput ;
	private String author ;
	private int submitedC;
	private int  solvedC;

	public String getTitle() {
		return title;
	}
	public void setTitle(String title) {
		this.title = title;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public int getCalTimeout() {
		return calTimeout;
	}
	public void setCalTimeout(int calTimeout) {
		this.calTimeout = calTimeout;
	}
	public int getRunTimeout() {
		return runTimeout;
	}
	public void setRunTimeout(int runTimeout) {
		this.runTimeout = runTimeout;
	}
	public String getInput() {
		return input;
	}
	public void setInput(String input) {
		this.input = input;
	}
	public String getOutput() {
		return output;
	}
	public void setOutput(String output) {
		this.output = output;
	}
	public String getSpInput() {
		return spInput;
	}
	public void setSpInput(String spInput) {
		this.spInput = spInput;
	}
	public String getSpOutput() {
		return spOutput;
	}
	public void setSpOutput(String spOutput) {
		this.spOutput = spOutput;
	}
	public String getAuthor() {
		return author;
	}
	public void setAuthor(String author) {
		this.author = author;
	}
	public int getSubmitedC() {
		return submitedC;
	}
	public void setSubmitedC(int submitedC) {
		this.submitedC = submitedC;
	}
	public int getSolvedC() {
		return solvedC;
	}
	public void setSolvedC(int solvedC) {
		this.solvedC = solvedC;
	}
	public int getProblem_id() {
		return problem_id;
	}
	public void setProblem_id(int problem_id) {
		this.problem_id = problem_id;
	}
	
}
