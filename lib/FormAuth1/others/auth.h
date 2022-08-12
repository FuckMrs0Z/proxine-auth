#pragma once
#include <string>
#include <vector>
extern bool IsValid;

class program
{
public:
	static std::tuple<std::string, std::string, std::string> login(std::string key, std::string userid, std::string pid, std::string programname, std::string skey);


};