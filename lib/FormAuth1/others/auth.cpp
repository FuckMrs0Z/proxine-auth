#pragma comment(lib, "libcurl.lib")
#pragma comment (lib, "Normaliz.lib")
#pragma comment (lib, "Ws2_32.lib")
#pragma comment (lib, "Wldap32.lib")
#pragma comment (lib, "Crypt32.lib")
#pragma comment (lib, "advapi32.lib")
#include "auth.h"
#include <iostream>
#include <string>
#include "../others/hwid.h"
#include <iostream>
#include <stdio.h>
#include "../curl/curl.h"
#include "../crypto/crypto.h"
#include "../others/xor.h"
#include "../hashlib/md5wrapper.h"
#include "../base64.h"
std::string arep;
std::string GetCurrentDirectory()
{
	char buffer[MAX_PATH];
	GetModuleFileNameA(NULL, buffer, MAX_PATH);
	std::string::size_type pos = std::string(buffer).find_last_of("\\/");

	return std::string(buffer);
}
size_t writefunc(void* ptr, size_t size, size_t nmemb, std::string* s)
{
	s->append(static_cast<char*>(ptr), size * nmemb);
	return size * nmemb;
}
size_t WriteCallbacks(void* contents, size_t size, size_t nmemb, void* userp)
{
	((std::string*)userp)->append((char*)contents, size * nmemb);
	return size * nmemb;
}
size_t WriteCallbacksDLL(void* contents, size_t size, size_t nmemb, void* userp)
{
	((std::string*)userp)->append((char*)contents, size * nmemb);
	return size * nmemb;
}

void replaceAll(std::string& str, const std::string& from, const std::string& to) {
	if (from.empty())
		return;
	size_t start_pos = 0;
	while ((start_pos = str.find(from, start_pos)) != std::string::npos) {
		str.replace(start_pos, from.length(), to);
		start_pos += to.length();
	}
}
void strGetRandomAlphaNum(std::string sStr, unsigned int iLen)
{
	char Syms[] = "123456789ABCDEFGHH";
	unsigned int Ind = 0;
	srand(time(NULL) + rand());
	while (Ind < iLen)
	{
		sStr[Ind++] = Syms[rand() % 62];
	}
	sStr[iLen] = '\0';
}

static std::string RandomString(std::string::size_type length)
{
	static auto& chrs = "0123456789"
		"abcdefghijklmnopqrstuvwxyz"
		"ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	thread_local static std::mt19937 rg{ std::random_device{}() };
	thread_local static std::uniform_int_distribution<std::string::size_type> pick(0, sizeof(chrs) - 2);

	std::string s;

	s.reserve(length);

	while (length--)
		s += chrs[pick(rg)];

	return s;
}

std::tuple<std::string, std::string, std::string> program::login(std::string key, std::string userid, std::string pid, std::string programname, std::string skey)
{
start:
    std::string aiv = RandomString(16);
    auto md5 = new md5wrapper();
    std::string hash = md5->getHashFromFile(GetCurrentDirectoryA());
    std::string id;
    std::string pi;
    std::string eiv;
    std::string ekey;
    std::string ename;
    std::string ehwid;
    CryptoPP::StringSource ss(hwid::get_hardware_id(), true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(ehwid)));
    CryptoPP::StringSource ss1(userid, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(id)));
    CryptoPP::StringSource ss3(pid, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(pi)));
    CryptoPP::StringSource ss4(key, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(ekey)));
    CryptoPP::StringSource ss5(programname, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(ename)));
    CryptoPP::StringSource ss22(aiv, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(eiv)));
    std::string euid = security::encrypt(userid, skey, aiv);
    std::string epid = security::encrypt(pid, skey, aiv);
    while (epid.find("+") != std::string::npos)
    {
        aiv = RandomString(16);
        euid = security::encrypt(userid, skey, aiv);
        epid = security::encrypt(pid, skey, aiv);
        CryptoPP::StringSource ss11(aiv, true, new CryptoPP::HexEncoder(new CryptoPP::StringSink(eiv)));
    }


    CURL* curl = curl_easy_init();
    if (curl)
    {
        CURL* curl = curl_easy_init();
        if (curl)
        {
            std::string ssl = _xor_("sha256//vybo987ja/HEgYo9xpgJ4b+iloaeh+H8K9NhMjn6oXI=");
            std::string s1;
            std::string api = _xor_("https://auth.accode.xyz/api/login.php?id=").c_str() + ekey + _xor_("&uuid=") + euid + _xor_("&hwid=");
            std::string login = api + ehwid + _xor_("&current=") + eiv + _xor_("&a=") + epid + _xor_("&h=") + hash + _xor_("&ppn=") + ename;

            curl_easy_setopt(curl, CURLOPT_URL, login.c_str());
            curl_easy_setopt(curl, CURLOPT_WRITEFUNCTION, writefunc);
            curl_easy_setopt(curl, CURLOPT_WRITEDATA, &s1);
            // curl_easy_setopt(curl, CURLOPT_VERBOSE, 1L);
            curl_easy_setopt(curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_easy_setopt(curl, CURLOPT_PINNEDPUBLICKEY, ssl.c_str());
            CURLcode res = curl_easy_perform(curl);
            arep = security::decrypt(s1.c_str(), skey, aiv);
            curl_easy_cleanup(curl);
            if (arep.length() > 85)
            {
                goto start;
            }
            else
            {
                std::string status;
                std::string level;
                std::string expiry;

                int index = 0;
                std::string s = arep;
                std::string delimiter = ".";

                size_t pos = 0;
                std::string token;
                while ((pos = s.find(delimiter)) != std::string::npos)
                {
                    token = s.substr(0, pos);
                    s.erase(0, pos + delimiter.length());

                    if (index == 0)
                        status = token;
                    else if (index == 1)
                        level = token;

                    index++;
                }
                expiry = s;
                std::string ex;
                CryptoPP::StringSource s2s(s, true, new CryptoPP::HexDecoder(new CryptoPP::StringSink(ex)));
                if (status.empty())
                {
                    goto start;
                }
                return std::make_tuple(status, level, ex);
            }
        }
    }

}